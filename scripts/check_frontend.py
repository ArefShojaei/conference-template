#!/usr/bin/env python3
"""Lightweight regression checks for the static HTML preview."""
from html.parser import HTMLParser
from pathlib import Path
from urllib.parse import urlsplit

ROOT = Path(__file__).resolve().parents[1]
HTML_FILES = sorted(ROOT.glob("*.html"))
PANEL_PAGES = {
    "login.html", "register.html", "forgot-password.html", "dashboard.html",
    "profile.html", "my-papers.html", "certificates.html",
    "admin-dashboard.html", "admin-papers.html", "admin-posts.html",
    "admin-registrations.html", "admin-settings.html", "admin-team.html",
    "admin-users.html",
}

class PageParser(HTMLParser):
    def __init__(self):
        super().__init__()
        self.ids = set()
        self.duplicates = []
        self.links = []
        self.title = False
        self.description = False
        self.noindex = False
        self.in_title = False

    def handle_starttag(self, tag, attrs):
        attrs = dict(attrs)
        ident = attrs.get("id")
        if ident:
            if ident in self.ids:
                self.duplicates.append(ident)
            self.ids.add(ident)
        if tag in ("a", "link", "script", "img", "source"):
            key = "href" if tag in ("a", "link") else "src"
            if attrs.get(key):
                self.links.append(attrs[key])
        if tag == "meta":
            name = (attrs.get("name") or "").lower()
            if name == "description" and attrs.get("content", "").strip():
                self.description = True
            if name == "robots" and "noindex" in attrs.get("content", "").lower():
                self.noindex = True
        if tag == "title":
            self.in_title = True

    def handle_endtag(self, tag):
        if tag == "title":
            self.in_title = False

    def handle_data(self, data):
        if self.in_title and data.strip():
            self.title = True

errors = []
known_ids = {}
parsers = {}

for page in HTML_FILES:
    parser = PageParser()
    parser.feed(page.read_text(encoding="utf-8"))
    parsers[page.name] = parser
    known_ids[page.name] = parser.ids
    if not parser.title:
        errors.append(f"{page.name}: missing non-empty title")
    if not parser.description:
        errors.append(f"{page.name}: missing meta description")
    if page.name in PANEL_PAGES and not parser.noindex:
        errors.append(f"{page.name}: panel/auth page should declare noindex")
    for ident in parser.duplicates:
        errors.append(f"{page.name}: duplicate id '{ident}'")

for page in HTML_FILES:
    parser = parsers[page.name]
    for raw in parser.links:
        if raw.startswith(("#", "mailto:", "tel:", "javascript:", "data:")):
            continue
        parsed = urlsplit(raw)
        if parsed.scheme or parsed.netloc:
            continue
        target = (ROOT / page.parent.relative_to(ROOT) / parsed.path).resolve()
        if not target.exists():
            errors.append(f"{page.name}: missing local target '{raw}'")
            continue
        if parsed.fragment and target.suffix.lower() == ".html":
            target_name = target.name
            if target_name in known_ids and parsed.fragment not in known_ids[target_name]:
                errors.append(f"{page.name}: missing anchor '{parsed.fragment}' in '{target_name}'")

if errors:
    print("Frontend regression checks FAILED:")
    for error in errors:
        print(" - " + error)
    raise SystemExit(1)

print(f"Frontend regression checks passed: {len(HTML_FILES)} HTML pages; titles, descriptions, panel robots, IDs and local links verified.")
