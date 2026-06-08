<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tata Surya — Masuk</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/login.css" />
</head>
<body>

  <canvas id="spaceCanvas"></canvas>
  <div class="glow-orb orb-1"></div>
  <div class="glow-orb orb-2"></div>

  <!-- MODAL LUPA PASSWORD -->
  <div class="modal-overlay" id="modalForgot" onclick="closeForgot(event)">
    <div class="modal-box">
      <h2 class="modal-title">Reset Password</h2>
      <p class="modal-desc">Masukkan username kamu, lalu masukkan password baru.</p>
      <div class="field">
        <label for="fpUser">Username</label>
        <input type="text" id="fpUser" placeholder="username terdaftar" autocomplete="off"/>
      </div>
      <div class="field">
        <label for="fpNewPass">Password Baru</label>
        <div class="pass-wrap">
          <input type="password" id="fpNewPass" placeholder="min. 6 karakter" autocomplete="new-password"/>
          <button class="eye-btn" onclick="toggleEye('fpNewPass',this)" tabindex="-1">
            <svg class="eye-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>
      <div class="field">
        <label for="fpNewPass2">Konfirmasi Password Baru</label>
        <div class="pass-wrap">
          <input type="password" id="fpNewPass2" placeholder="ulangi password baru" autocomplete="new-password"/>
          <button class="eye-btn" onclick="toggleEye('fpNewPass2',this)" tabindex="-1">
            <svg class="eye-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>
      <div class="alert" id="alertForgot"></div>
      <div class="modal-actions">
        <button class="btn-secondary" onclick="closeForgot()">Batal</button>
        <button class="btn-primary modal-btn" id="btnForgot" onclick="doReset()">
          <span class="btn-lbl">Reset Password</span>
        </button>
      </div>
    </div>
  </div>

  <main class="page-center">

    <div class="brand">
      <div class="brand-ring">
        <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="40" cy="40" r="36" stroke="url(#rg)" stroke-width="1.5" stroke-dasharray="6 3"/>
          <circle cx="40" cy="4" r="4" fill="#f5c842"/>
          <circle cx="40" cy="40" r="14" fill="url(#pg)"/>
          <ellipse cx="40" cy="40" rx="26" ry="7" stroke="url(#rg)" stroke-width="1" fill="none" opacity="0.5"/>
          <defs>
            <linearGradient id="rg" x1="0" y1="0" x2="80" y2="80">
              <stop offset="0%" stop-color="#a8d8f0"/>
              <stop offset="100%" stop-color="#4a90d9"/>
            </linearGradient>
            <radialGradient id="pg" cx="35%" cy="35%">
              <stop offset="0%" stop-color="#7ec8e3"/>
              <stop offset="60%" stop-color="#1a6fa8"/>
              <stop offset="100%" stop-color="#0a2e4a"/>
            </radialGradient>
          </defs>
        </svg>
      </div>
      <h1 class="brand-name">TATA SURYA</h1>
      <p class="brand-sub">Jelajahi antariksa dalam genggamanmu</p>
    </div>

    <div class="card">
      <div class="tabs">
        <button class="tab active" id="tabLogin" onclick="switchTab('login')">Masuk</button>
        <button class="tab" id="tabRegister" onclick="switchTab('register')">Daftar</button>
        <div class="tab-slider" id="tabSlider"></div>
      </div>

      <!-- LOGIN -->
      <div class="panel" id="panelLogin">
        <div class="field">
          <label for="loginUser">Username</label>
          <input type="text" id="loginUser" placeholder="username kamu" spellcheck="false" autocomplete="off"/>
        </div>
        <div class="field">
          <label for="loginPass">Password</label>
          <div class="pass-wrap">
            <input type="password" id="loginPass" placeholder="••••••••" autocomplete="current-password"/>
            <button class="eye-btn" onclick="toggleEye('loginPass',this)" tabindex="-1">
              <svg class="eye-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
        </div>
        <div class="row-opt">
          <label class="check-label">
            <input type="checkbox" id="rememberMe"/>
            <span class="box"></span>
            Ingat saya
          </label>
          <button class="link-sm" onclick="openForgot()">Lupa password?</button>
        </div>
        <div class="alert" id="alertLogin"></div>
        <button class="btn-primary" id="btnLogin" onclick="doLogin()">
          <span class="btn-lbl">Masuk</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
        <p class="switch-hint">Belum punya akun? <a onclick="switchTab('register')">Daftar sekarang</a></p>
      </div>

      <!-- REGISTER -->
      <div class="panel hidden" id="panelRegister">
        <div class="field">
          <label for="regName">Nama Lengkap</label>
          <input type="text" id="regName" placeholder="nama lengkapmu" autocomplete="off"/>
        </div>
        <div class="field">
          <label for="regUser">Username</label>
          <input type="text" id="regUser" placeholder="buat username unik" spellcheck="false" autocomplete="off"/>
        </div>
        <div class="field">
          <label for="regPass">Password</label>
          <div class="pass-wrap">
            <input type="password" id="regPass" placeholder="min. 6 karakter" autocomplete="new-password"/>
            <button class="eye-btn" onclick="toggleEye('regPass',this)" tabindex="-1">
              <svg class="eye-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
        </div>
        <div class="field">
          <label for="regPass2">Konfirmasi Password</label>
          <div class="pass-wrap">
            <input type="password" id="regPass2" placeholder="ulangi password" autocomplete="new-password"/>
            <button class="eye-btn" onclick="toggleEye('regPass2',this)" tabindex="-1">
              <svg class="eye-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
        </div>
        <div class="alert" id="alertRegister"></div>
        <button class="btn-primary" id="btnRegister" onclick="doRegister()">
          <span class="btn-lbl">Daftarkan Akun</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
        </button>
        <p class="switch-hint">Sudah punya akun? <a onclick="switchTab('login')">Masuk di sini</a></p>
      </div>

    </div><!-- /card -->
  </main>

<script src="db.js"></script>
<script>
/* ===== INIT DB ===== */
document.addEventListener('DOMContentLoaded', async () => {
  await db.init();
  // Cek remember me
  const rem = localStorage.getItem('pk_remember');
  if (rem) document.getElementById('loginUser').value = rem;
});

/* ===== STARFIELD ===== */
(function(){
  const c=document.getElementById('spaceCanvas'),ctx=c.getContext('2d');
  let W,H,stars=[];
  function resize(){W=c.width=innerWidth;H=c.height=innerHeight;}
  function init(){stars=[];for(let i=0;i<200;i++)stars.push({x:Math.random()*W,y:Math.random()*H,r:Math.random()*1.3+0.2,a:Math.random(),da:(Math.random()*.005+.002)*(Math.random()<.5?1:-1),cold:Math.random()<.15});}
  function loop(){ctx.clearRect(0,0,W,H);stars.forEach(s=>{s.a+=s.da;if(s.a>1||s.a<0)s.da*=-1;ctx.beginPath();ctx.arc(s.x,s.y,s.r,0,Math.PI*2);ctx.fillStyle=s.cold?'#aed6f1':'#fff';ctx.globalAlpha=s.a;ctx.fill();});ctx.globalAlpha=1;requestAnimationFrame(loop);}
  resize();init();loop();
  window.addEventListener('resize',()=>{resize();init();});
})();

/* ===== TABS ===== */
function switchTab(w){
  const tL=document.getElementById('tabLogin'),tR=document.getElementById('tabRegister');
  const pL=document.getElementById('panelLogin'),pR=document.getElementById('panelRegister');
  const sl=document.getElementById('tabSlider');
  clearAlert('alertLogin');clearAlert('alertRegister');
  if(w==='login'){
    tL.classList.add('active');tR.classList.remove('active');
    sl.style.transform='translateX(0)';sl.style.width=tL.offsetWidth+'px';
    pL.classList.remove('hidden');pR.classList.add('hidden');
  } else {
    tR.classList.add('active');tL.classList.remove('active');
    sl.style.transform='translateX('+tL.offsetWidth+'px)';sl.style.width=tR.offsetWidth+'px';
    pR.classList.remove('hidden');pL.classList.add('hidden');
  }
}
window.addEventListener('load',()=>{
  const tL=document.getElementById('tabLogin'),sl=document.getElementById('tabSlider');
  sl.style.width=tL.offsetWidth+'px';sl.style.transform='translateX(0)';
});

/* ===== EYE TOGGLE ===== */
function toggleEye(id,btn){
  const inp=document.getElementById(id),show=inp.type==='password';
  inp.type=show?'text':'password';
  btn.querySelector('.eye-svg').innerHTML=show
    ?`<path d="M17.94 17.94A10 10 0 0112 20C5 20 1 12 1 12a18 18 0 015.06-5.94"/><path d="M9.9 4.24A9 9 0 0112 4c7 0 11 8 11 8a18 18 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`
    :`<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
}

/* ===== ALERTS ===== */
function showAlert(id,msg,type){const e=document.getElementById(id);e.textContent=msg;e.className='alert show '+type;}
function clearAlert(id){const e=document.getElementById(id);e.className='alert';e.textContent='';}

/* ===== MODAL LUPA PASSWORD ===== */
function openForgot(){
  clearAlert('alertForgot');
  ['fpUser','fpNewPass','fpNewPass2'].forEach(id=>document.getElementById(id).value='');
  document.getElementById('btnForgot').querySelector('.btn-lbl').textContent='Reset Password';
  document.getElementById('btnForgot').disabled=false;
  document.getElementById('modalForgot').classList.add('open');
}
function closeForgot(e){
  if(e && e.target!==document.getElementById('modalForgot')) return;
  document.getElementById('modalForgot').classList.remove('open');
}

async function doReset(){
  const user=document.getElementById('fpUser').value.trim();
  const np=document.getElementById('fpNewPass').value;
  const np2=document.getElementById('fpNewPass2').value;
  const btn=document.getElementById('btnForgot');
  clearAlert('alertForgot');
  if(!user||!np||!np2){showAlert('alertForgot','Semua kolom wajib diisi.','err');return;}
  if(np.length<6){showAlert('alertForgot','Password baru minimal 6 karakter.','err');return;}
  if(np!==np2){showAlert('alertForgot','Konfirmasi password tidak cocok.','err');return;}
  btn.disabled=true;
  try {
    await db.resetPassword(user, np);
    btn.querySelector('.btn-lbl').textContent='Berhasil!';
    showAlert('alertForgot','Password berhasil direset! Silakan masuk.','ok');
    setTimeout(()=>{
      document.getElementById('modalForgot').classList.remove('open');
      switchTab('login');
      document.getElementById('loginUser').value=user;
    },1500);
  } catch(err) {
    btn.disabled=false;
    if(err.message==='USER_NOT_FOUND') showAlert('alertForgot','Username tidak ditemukan.','err');
    else if(err.message==='CANNOT_RESET_ADMIN') showAlert('alertForgot','Akun ini tidak dapat direset.','err');
    else showAlert('alertForgot','Terjadi kesalahan. Coba lagi.','err');
  }
}

/* ===== LOGIN ===== */
async function doLogin(){
  const user=document.getElementById('loginUser').value.trim();
  const pass=document.getElementById('loginPass').value;
  const remember=document.getElementById('rememberMe').checked;
  const btn=document.getElementById('btnLogin');
  clearAlert('alertLogin');
  if(!user||!pass){showAlert('alertLogin','Username dan password wajib diisi.','err');return;}
  btn.classList.add('loading');btn.disabled=true;
  try {
    const result = await db.login(user, pass);
    if(result){
      db.setSession(result);
      if(remember) localStorage.setItem('pk_remember', user);
      else localStorage.removeItem('pk_remember');
      showAlert('alertLogin','Berhasil! Mengalihkan...','ok');
      btn.querySelector('.btn-lbl').textContent='Berhasil!';
      setTimeout(()=>{window.location.href='home.php';},900);
    } else {
      btn.classList.remove('loading');btn.disabled=false;
      showAlert('alertLogin','Username atau password salah.','err');
    }
  } catch(e) {
    btn.classList.remove('loading');btn.disabled=false;
    showAlert('alertLogin','Terjadi kesalahan. Coba lagi.','err');
  }
}

/* ===== REGISTER ===== */
async function doRegister(){
  const name=document.getElementById('regName').value.trim();
  const user=document.getElementById('regUser').value.trim();
  const pass=document.getElementById('regPass').value;
  const pass2=document.getElementById('regPass2').value;
  const btn=document.getElementById('btnRegister');
  clearAlert('alertRegister');
  if(!name||!user||!pass||!pass2){showAlert('alertRegister','Semua kolom wajib diisi.','err');return;}
  if(pass.length<6){showAlert('alertRegister','Password minimal 6 karakter.','err');return;}
  if(pass!==pass2){showAlert('alertRegister','Password dan konfirmasi tidak cocok.','err');return;}
  btn.classList.add('loading');btn.disabled=true;
  try {
    await db.register(name, user, pass);
    showAlert('alertRegister','Akun berhasil dibuat! Silakan masuk.','ok');
    btn.querySelector('.btn-lbl').textContent='Berhasil!';
    setTimeout(()=>{
      btn.classList.remove('loading');btn.disabled=false;
      btn.querySelector('.btn-lbl').textContent='Daftarkan Akun';
      switchTab('login');
      document.getElementById('loginUser').value=user;
    },1400);
  } catch(err) {
    btn.classList.remove('loading');btn.disabled=false;
    if(err.message==='USERNAME_TAKEN') showAlert('alertRegister','Username sudah dipakai, coba yang lain.','err');
    else showAlert('alertRegister','Terjadi kesalahan. Coba lagi.','err');
  }
}

/* ===== ENTER KEY ===== */
document.addEventListener('keydown',e=>{
  if(e.key!=='Enter') return;
  if(document.getElementById('modalForgot').classList.contains('open')){doReset();return;}
  document.getElementById('panelLogin').classList.contains('hidden')?doRegister():doLogin();
});
</script>
</body>
</html>
