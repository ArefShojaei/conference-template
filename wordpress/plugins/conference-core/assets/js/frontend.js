(function(){
 const api=(path,options={})=>fetch(ConfCore.rest+path,Object.assign({credentials:'same-origin',headers:Object.assign({'X-WP-Nonce':ConfCore.nonce},options.headers||{})},options));
 const message=(form,text)=>{const el=form.querySelector('.confcore-message');if(el)el.textContent=text;};
 document.addEventListener('submit',async function(e){
  const form=e.target;
  if(form.matches('.confcore-otp-form')){
   e.preventDefault();const phone=form.querySelector('[name=phone]').value.trim();const mode=form.dataset.mode;
   try{const res=await api('otp/request',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({phone,mode})});const data=await res.json();if(!res.ok)throw new Error(data.message||'درخواست ناموفق بود');form.querySelector('.confcore-otp-step').hidden=false;form.querySelector('[type=submit]').disabled=true;message(form,data.message||'کد ارسال شد.');}
   catch(err){message(form,err.message);}
  }
  if(form.matches('.confcore-paper-form')){
   e.preventDefault();const data=new FormData(form);try{const res=await api('papers/upload',{method:'POST',body:data});const json=await res.json();if(!res.ok)throw new Error(json.message||'بارگذاری انجام نشد');message(form,json.message);form.reset();}
   catch(err){message(form,err.message);}
  }
 });
 document.addEventListener('click',async function(e){
  const btn=e.target.closest('[data-verify]');if(!btn)return;
  const form=btn.closest('.confcore-otp-form');const phone=form.querySelector('[name=phone]').value.trim();const code=form.querySelector('[name=code]').value.trim();
  try{btn.disabled=true;const res=await api('otp/verify',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({phone,code,mode:form.dataset.mode})});const data=await res.json();if(!res.ok)throw new Error(data.message||'کد تأیید نشد');message(form,data.message||'ورود موفق');window.location.assign(data.redirect||ConfCore.dashboard);}
  catch(err){message(form,err.message);btn.disabled=false;}
 });
})();