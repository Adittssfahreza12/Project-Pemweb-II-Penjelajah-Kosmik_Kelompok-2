function generateStars() {
  const container = document.getElementById('heroStars');
  if (!container) return;
  const count = 120;
  const fragment = document.createDocumentFragment();
  for (let i = 0; i < count; i++) {
    const star = document.createElement('div');
    const size = Math.random() * 2.5 + 0.5;
    star.style.cssText = `
      position: absolute;
      width: ${size}px;
      height: ${size}px;
      background: white;
      border-radius: 50%;
      top: ${Math.random() * 100}%;
      left: ${Math.random() * 100}%;
      opacity: ${Math.random() * 0.6 + 0.2};
      animation: twinkle ${Math.random() * 3 + 2}s ease-in-out infinite alternate;
      animation-delay: ${Math.random() * 3}s;
    `;
    fragment.appendChild(star);
  }
  container.appendChild(fragment);
}
const style = document.createElement('style');
style.textContent = `
  @keyframes twinkle {
    from { opacity: 0.2; transform: scale(1); }
    to   { opacity: 0.9; transform: scale(1.3); }
  }
`;
document.head.appendChild(style);
generateStars();

const allQuestions = {
  mudah: [
    { q: "Planet apa yang paling dekat dengan Matahari?", opts: ["Venus", "Mars", "Merkurius", "Bumi"], ans: 2, icon: "☀️", explain: "Merkurius adalah planet terdekat dengan Matahari dalam tata surya kita." },
    { q: "Berapa jumlah planet di Tata Surya kita?", opts: ["7", "8", "9", "10"], ans: 1, icon: "🪐", explain: "Tata Surya kita memiliki 8 planet resmi sejak Pluto diklasifikasikan ulang tahun 2006." },
    { q: "Planet mana yang dikenal sebagai Planet Merah?", opts: ["Jupiter", "Mars", "Saturnus", "Venus"], ans: 1, icon: "🔴", explain: "Mars disebut Planet Merah karena permukaannya kaya akan oksida besi (karat)." },
    { q: "Planet apa yang terbesar di Tata Surya?", opts: ["Saturnus", "Neptunus", "Jupiter", "Uranus"], ans: 2, icon: "🌟", explain: "Jupiter adalah planet terbesar, massanya lebih dari 2 kali gabungan semua planet lainnya." },
    { q: "Berapa lama cahaya Matahari mencapai Bumi?", opts: ["8 menit 20 detik", "1 jam", "30 detik", "2 hari"], ans: 0, icon: "💡", explain: "Cahaya merambat dengan kecepatan ~300.000 km/s, butuh sekitar 8 menit 20 detik dari Matahari ke Bumi." },
    { q: "Planet apa yang memiliki cincin paling terkenal?", opts: ["Jupiter", "Uranus", "Saturnus", "Neptunus"], ans: 2, icon: "💍", explain: "Saturnus terkenal dengan sistem cincinnya yang indah dan besar, terbuat dari es dan batuan." },
    { q: "Apa nama bulan Bumi?", opts: ["Titan", "Europa", "Luna", "Ganymede"], ans: 2, icon: "🌕", explain: "Bulan Bumi bernama Luna (atau Moon dalam bahasa Inggris)." },
    { q: "Planet mana yang paling jauh dari Matahari?", opts: ["Uranus", "Saturnus", "Pluto", "Neptunus"], ans: 3, icon: "🔭", explain: "Neptunus adalah planet terjauh dari Matahari, berjarak sekitar 4,5 miliar km." },
    { q: "Apa bintang terdekat dengan Bumi?", opts: ["Sirius", "Alpha Centauri", "Matahari", "Vega"], ans: 2, icon: "⭐", explain: "Matahari adalah bintang terdekat dengan Bumi, berjarak sekitar 150 juta km." },
    { q: "Planet mana yang berotasi dari timur ke barat (terbalik)?", opts: ["Mars", "Venus", "Jupiter", "Merkurius"], ans: 1, icon: "🔄", explain: "Venus berotasi dari timur ke barat, berlawanan dengan kebanyakan planet termasuk Bumi." },
  ],
  sedang: [
    { q: "Berapa kira-kira usia Alam Semesta?", opts: ["4,5 miliar tahun", "13,8 miliar tahun", "10 miliar tahun", "20 miliar tahun"], ans: 1, icon: "🌌", explain: "Alam Semesta diperkirakan berusia sekitar 13,8 miliar tahun berdasarkan pengamatan radiasi latar kosmik." },
    { q: "Bulan Jupiter mana yang terbesar di Tata Surya?", opts: ["Europa", "Io", "Callisto", "Ganymede"], ans: 3, icon: "🪐", explain: "Ganymede adalah bulan terbesar di Tata Surya, bahkan lebih besar dari planet Merkurius." },
    { q: "Planet apa yang memiliki angin tercepat di Tata Surya?", opts: ["Jupiter", "Saturnus", "Neptunus", "Uranus"], ans: 2, icon: "💨", explain: "Neptunus memiliki angin tercepat hingga 2.100 km/jam, jauh lebih cepat dari planet lainnya." },
    { q: "Apa yang dimaksud dengan 'tahun cahaya'?", opts: ["Waktu yang diperlukan cahaya mengelilingi Bumi", "Jarak yang ditempuh cahaya dalam satu tahun", "Kecepatan cahaya per tahun", "Lamanya cahaya dari Matahari"], ans: 1, icon: "💫", explain: "Tahun cahaya adalah satuan jarak, bukan waktu. Satu tahun cahaya ≈ 9,46 triliun kilometer." },
    { q: "Planet apa yang satu harinya lebih panjang dari satu tahunnya?", opts: ["Merkurius", "Venus", "Mars", "Jupiter"], ans: 1, icon: "⏰", explain: "Satu hari di Venus berlangsung 243 hari Bumi, sementara satu tahun Venus hanya 225 hari Bumi." },
    { q: "Apa nama galaksi tempat Tata Surya kita berada?", opts: ["Andromeda", "Triangulum", "Bima Sakti", "Sombrero"], ans: 2, icon: "🌀", explain: "Tata Surya kita berada di galaksi Bima Sakti (Milky Way), galaksi spiral berpalang." },
    { q: "Berapa suhu permukaan Matahari (fotosfer)?", opts: ["1.000°C", "5.500°C", "10.000°C", "50.000°C"], ans: 1, icon: "🔥", explain: "Permukaan Matahari (fotosfer) memiliki suhu sekitar 5.500°C, sedangkan korona bisa mencapai jutaan derajat." },
    { q: "Planet mana yang memiliki hari paling pendek (rotasi tercepat)?", opts: ["Saturnus", "Jupiter", "Mars", "Uranus"], ans: 1, icon: "⚡", explain: "Jupiter berotasi sangat cepat, satu hari di Jupiter hanya sekitar 10 jam Bumi." },
    { q: "Apa komposisi utama cincin Saturnus?", opts: ["Batu dan debu", "Gas dan plasma", "Es dan batuan", "Air dan logam"], ans: 2, icon: "💍", explain: "Cincin Saturnus sebagian besar terbuat dari partikel es dan batuan, mulai dari seukuran butiran hingga gunung." },
    { q: "Fenomena apa yang menyebabkan terjadinya gerhana bulan?", opts: ["Bulan menutupi Matahari", "Bumi berada di antara Matahari dan Bulan", "Bulan berada di antara Bumi dan Matahari", "Bayangan bulan jatuh ke Bumi"], ans: 1, icon: "🌑", explain: "Gerhana bulan terjadi saat Bumi berada di antara Matahari dan Bulan, sehingga bayangan Bumi menutupi Bulan." },
  ],
  sulit: [
    { q: "Berapakah kecepatan lepas (escape velocity) dari Bumi?", opts: ["7,9 km/s", "11,2 km/s", "15,5 km/s", "9,8 km/s"], ans: 1, icon: "🚀", explain: "Kecepatan lepas dari Bumi adalah 11,2 km/s, yaitu kecepatan minimum untuk lolos dari gravitasi Bumi." },
    { q: "Apa nama proses fusi nuklir yang terjadi di inti Matahari?", opts: ["Siklus CNO dan Rantai Proton-Proton", "Reaksi fisi uranium", "Pembakaran helium", "Reaksi Bethe"], ans: 0, icon: "⚛️", explain: "Di Matahari terjadi dua proses utama: Rantai Proton-Proton (dominan) dan Siklus CNO (karbon-nitrogen-oksigen)." },
    { q: "Berapa perkiraan jarak Bumi ke pusat galaksi Bima Sakti?", opts: ["2.600 tahun cahaya", "8.500 parsec", "26.000 tahun cahaya", "100.000 tahun cahaya"], ans: 2, icon: "🌌", explain: "Tata Surya berada sekitar 26.000 tahun cahaya (8.000 parsec) dari pusat galaksi Bima Sakti." },
    { q: "Apa yang dimaksud dengan radiasi Hawking?", opts: ["Radiasi dari bintang neutron", "Radiasi dari lubang hitam yang menyebabkan penguapan bertahap", "Radiasi kosmik latar belakang", "Gelombang gravitasi dari lubang hitam"], ans: 1, icon: "🕳️", explain: "Radiasi Hawking adalah proses teoritis di mana lubang hitam memancarkan partikel dan perlahan menyusut." },
    { q: "Planet apa yang sumbu rotasinya hampir sejajar bidang orbitnya (miring ~98°)?", opts: ["Saturnus", "Neptunus", "Uranus", "Venus"], ans: 2, icon: "🌀", explain: "Uranus memiliki kemiringan aksial ~97,8°, sehingga seolah-olah ia 'berbaring' saat mengorbit Matahari." },
    { q: "Berapa perkiraan massa Matahari dalam kilogram?", opts: ["2 × 10²⁸ kg", "2 × 10³⁰ kg", "2 × 10³² kg", "2 × 10²⁶ kg"], ans: 1, icon: "⚖️", explain: "Massa Matahari sekitar 1,989 × 10³⁰ kg, setara dengan sekitar 330.000 kali massa Bumi." },
    { q: "Apa yang menyebabkan warna biru Neptunus dan Uranus?", opts: ["Nitrogen cair", "Metana yang menyerap cahaya merah", "Hidrogen cair", "Uap air dalam atmosfer"], ans: 1, icon: "🔵", explain: "Gas metana (CH₄) di atmosfer menyerap cahaya merah dan memantulkan cahaya biru, memberi warna khas biru/hijau." },
    { q: "Apa nama teleskop yang meluncur tahun 2021 pengganti Hubble?", opts: ["Teleskop Chandra", "Teleskop James Webb", "Teleskop Spitzer", "Teleskop Kepler"], ans: 1, icon: "🔭", explain: "Teleskop Luar Angkasa James Webb (JWST) diluncurkan 25 Desember 2021, mengamati inframerah jauh." },
    { q: "Berapa lama satu tahun di planet Neptunus?", opts: ["84 tahun Bumi", "165 tahun Bumi", "248 tahun Bumi", "29 tahun Bumi"], ans: 1, icon: "📅", explain: "Satu tahun di Neptunus setara dengan sekitar 165 tahun Bumi, karena orbitnya yang sangat jauh." },
    { q: "Galaksi mana yang akan bertabrakan dengan Bima Sakti sekitar 4 miliar tahun lagi?", opts: ["Galaksi Triangulum", "Galaksi Andromeda", "Galaksi Sombrero", "Awan Magellan Besar"], ans: 1, icon: "💥", explain: "Galaksi Andromeda (M31) sedang mendekati Bima Sakti dengan kecepatan ~110 km/s dan akan bertabrakan sekitar 4 miliar tahun lagi." },
  ]
};

let currentDifficulty = 'mudah';
let questions = [];
let currentIndex = 0;
let score = 0;
let correctCount = 0;
let wrongCount = 0;
let timerInterval = null;
let timeLeft = 15;
const TIME_LIMIT = 15;
let answerHistory = [];
let currentQuestionLocked = false;
let quizSaved = false;

function getActiveUser() {
  try {
    const raw = sessionStorage.getItem('pk_user');
    return raw ? JSON.parse(raw) : null;
  } catch (e) {
    return null;
  }
}

async function postJSON(url, payload) {
  const res = await fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  });
  if (!res.ok) throw new Error('NETWORK_ERROR');
  return await res.json();
}

function recordAnswer(selectedIndex, isCorrect, remainingSeconds) {
  if (currentQuestionLocked) return;

  const q = questions[currentIndex];
  if (!q) return;

  currentQuestionLocked = true;
  answerHistory[currentIndex] = {
    nomor_soal: currentIndex + 1,
    pertanyaan: q.q,
    jawaban_pilihan: selectedIndex,
    jawaban_benar: q.ans,
    adalah_benar: isCorrect ? 1 : 0,
    sisa_waktu: Math.max(0, remainingSeconds)
  };
}

async function saveQuizHistory() {
  const user = getActiveUser();
  if (!user || !user.id || quizSaved) return;
  quizSaved = true;

  const details = answerHistory.filter(Boolean);
  try {
    await postJSON('kuis_api.php', {
      action: 'save',
      user_id: user.id,
      tingkat_kesulitan: currentDifficulty,
      total_soal: questions.length,
      jawaban_benar: correctCount,
      jawaban_salah: wrongCount,
      skor: score,
      persentase: Math.round((correctCount / questions.length) * 10000) / 100,
      details
    });
  } catch (e) {}
}

function setDifficulty(level, el) {
  currentDifficulty = level;
  document.querySelectorAll('.diff-btn').forEach(btn => btn.classList.remove('active'));
  el.classList.add('active');
}

function shuffle(arr) {
  const a = [...arr];
  for (let i = a.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [a[i], a[j]] = [a[j], a[i]];
  }
  return a;
}

function startQuiz() {
  questions = shuffle(allQuestions[currentDifficulty]).slice(0, 10);
  currentIndex = 0;
  score = 0;
  correctCount = 0;
  wrongCount = 0;
  answerHistory = [];
  currentQuestionLocked = false;
  quizSaved = false;
  document.getElementById('totalQ').textContent = questions.length;
  showScreen('quizScreen');
  loadQuestion();
}

function showScreen(id) {
  document.querySelectorAll('.kuis-screen').forEach(s => s.classList.add('hidden'));
  document.getElementById(id).classList.remove('hidden');
}

function loadQuestion() {
  clearInterval(timerInterval);
  currentQuestionLocked = false;
  const q = questions[currentIndex];
  document.getElementById('questionNum').textContent = `Pertanyaan ${currentIndex + 1}`;
  document.getElementById('questionIcon').textContent = q.icon;
  document.getElementById('questionText').textContent = q.q;
  document.getElementById('currentScore').textContent = score;
  document.getElementById('progressFill').style.width = `${(currentIndex / questions.length) * 100}%`;
  document.getElementById('feedbackBox').classList.add('hidden');
  document.getElementById('feedbackBox').className = 'feedback-box hidden';
  document.getElementById('nextBtn').classList.add('hidden');

  const grid = document.getElementById('optionsGrid');
  grid.innerHTML = '';
  q.opts.forEach((opt, i) => {
    const btn = document.createElement('button');
    btn.className = 'option-btn';
    btn.textContent = opt;
    btn.onclick = () => selectAnswer(i);
    grid.appendChild(btn);
  });

  timeLeft = TIME_LIMIT;
  updateTimer();
  timerInterval = setInterval(() => {
    timeLeft--;
    updateTimer();
    if (timeLeft <= 0) {
      clearInterval(timerInterval);
      timeExpired();
    }
  }, 1000);
}

function updateTimer() {
  const fill = document.getElementById('timerFill');
  document.getElementById('timerText').textContent = timeLeft;
  fill.style.width = `${(timeLeft / TIME_LIMIT) * 100}%`;
  if (timeLeft <= 5) fill.classList.add('urgent');
  else fill.classList.remove('urgent');
}

function timeExpired() {
  if (currentQuestionLocked) return;
  clearInterval(timerInterval);
  disableOptions();
  const q = questions[currentIndex];
  document.querySelectorAll('.option-btn')[q.ans].classList.add('correct');
  wrongCount++;
  recordAnswer(255, false, 0);
  showFeedback(false, `⏰ Waktu habis! Jawaban yang benar: ${q.opts[q.ans]}. ${q.explain}`);
  document.getElementById('nextBtn').classList.remove('hidden');
}

function selectAnswer(idx) {
  if (currentQuestionLocked) return;
  clearInterval(timerInterval);
  const q = questions[currentIndex];
  const btns = document.querySelectorAll('.option-btn');
  disableOptions();

  if (idx === q.ans) {
    btns[idx].classList.add('correct');
    const points = Math.max(1, Math.ceil(timeLeft / TIME_LIMIT * 10));
    score += points;
    correctCount++;
    recordAnswer(idx, true, timeLeft);
    showFeedback(true, `✅ Benar! +${points} poin. ${q.explain}`);
  } else {
    btns[idx].classList.add('wrong');
    btns[q.ans].classList.add('correct');
    wrongCount++;
    recordAnswer(idx, false, timeLeft);
    showFeedback(false, `❌ Salah. Jawaban yang benar: ${q.opts[q.ans]}. ${q.explain}`);
  }
  document.getElementById('currentScore').textContent = score;
  document.getElementById('nextBtn').classList.remove('hidden');
}

function disableOptions() {
  document.querySelectorAll('.option-btn').forEach(btn => btn.disabled = true);
}

function showFeedback(isCorrect, text) {
  const box = document.getElementById('feedbackBox');
  box.className = `feedback-box ${isCorrect ? 'correct-fb' : 'wrong-fb'}`;
  document.getElementById('feedbackIcon').textContent = isCorrect ? '🎉' : '💡';
  document.getElementById('feedbackText').textContent = text;
}

function nextQuestion() {
  currentIndex++;
  if (currentIndex >= questions.length) {
    showResults();
  } else {
    loadQuestion();
  }
}

function showResults() {
  showScreen('resultScreen');
  document.getElementById('progressFill').style.width = '100%';
  document.getElementById('finalScore').textContent = correctCount;
  document.getElementById('maxScore').textContent = questions.length;

  const pct = Math.round((correctCount / questions.length) * 100);
  document.getElementById('percentText').textContent = pct + '%';
  setTimeout(() => {
    const circle = document.getElementById('percentCircle');
    circle.style.strokeDashoffset = 314 - (314 * pct / 100);
    circle.style.transition = 'stroke-dashoffset 1.5s ease';
  }, 100);

  let icon, title, message;
  if (pct >= 90)      { icon = '🏆'; title = 'Luar Biasa!';    message = 'Kamu adalah Penjelajah Kosmik Sejati! Pengetahuanmu tentang alam semesta sangat mengesankan!'; }
  else if (pct >= 70) { icon = '🌟'; title = 'Hebat!';         message = 'Pengetahuan kosmikmu sangat baik! Terus jelajahi alam semesta!'; }
  else if (pct >= 50) { icon = '🚀'; title = 'Cukup Baik!';    message = 'Kamu sudah mengenal tata surya dengan baik. Terus belajar dan eksplorasi!'; }
  else                { icon = '🌙'; title = 'Jangan Menyerah!'; message = 'Alam semesta penuh misteri. Ulangi kuis dan tingkatkan pengetahuanmu!'; }

  document.getElementById('resultIcon').textContent = icon;
  document.getElementById('resultTitle').textContent = title;
  document.getElementById('resultMessage').textContent = message;
  document.getElementById('resultBreakdown').innerHTML = `
    <div class="breakdown-item"><div class="breakdown-num correct-num">${correctCount}</div><div class="breakdown-label">Benar</div></div>
    <div class="breakdown-item"><div class="breakdown-num wrong-num">${wrongCount}</div><div class="breakdown-label">Salah</div></div>
    <div class="breakdown-item"><div class="breakdown-num" style="color:var(--color-accent)">${score}</div><div class="breakdown-label">Total Poin</div></div>
  `;

  void saveQuizHistory();
}

function restartQuiz() {
  clearInterval(timerInterval);
  answerHistory = [];
  currentQuestionLocked = false;
  quizSaved = false;
  showScreen('startScreen');
}