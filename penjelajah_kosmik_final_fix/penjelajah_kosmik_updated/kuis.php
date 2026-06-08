<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kuis Tata Surya — Penjelajah Kosmik</title>
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/navbar.css" />
  <link rel="stylesheet" href="css/kuis.css" />
</head>
<body>

  <div id="heroStars" style="position:fixed;inset:0;z-index:0;pointer-events:none;"></div>

  <?php include 'navbar.php'; ?>

  <main class="page-wrapper">
    <div class="container">

      <div class="kuis-header">
        <p class="hero-eyebrow">✦ Uji Pengetahuanmu</p>
        <h1>Kuis <span class="accent">Tata Surya</span></h1>
        <p class="kuis-desc">Seberapa jauh kamu mengenal alam semesta?</p>
      </div>

      <div class="kuis-screen" id="startScreen">
        <div class="kuis-card">
          <div class="kuis-card-icon">🚀</div>
          <h2>Siap Memulai?</h2>
          <p>10 pertanyaan seru tentang planet dan tata surya menantimu!</p>
          <div class="difficulty-select">
            <p>Pilih Tingkat Kesulitan</p>
            <div class="difficulty-buttons">
              <button class="diff-btn active" onclick="setDifficulty('mudah', this)">😊 Mudah</button>
              <button class="diff-btn"        onclick="setDifficulty('sedang', this)">🤔 Sedang</button>
              <button class="diff-btn"        onclick="setDifficulty('sulit', this)">🔥 Sulit</button>
            </div>
          </div>
          <button class="btn-primary btn-wide" onclick="startQuiz()">Mulai Kuis</button>
        </div>
      </div>

      <div class="kuis-screen hidden" id="quizScreen">
        <div class="kuis-card kuis-card--quiz">
          <div class="quiz-meta">
            <span id="questionNum" class="quiz-meta-label">Pertanyaan 1</span>
            <span class="quiz-meta-label">dari <span id="totalQ">10</span></span>
            <span class="quiz-score">Skor: <span id="currentScore">0</span></span>
            <div class="timer-wrap">
              <div class="timer-bar"><div class="timer-fill" id="timerFill"></div></div>
              <span id="timerText">15</span>s
            </div>
          </div>
          <div class="quiz-progress">
            <div class="quiz-progress-fill" id="progressFill"></div>
          </div>
          <div class="question-area">
            <div class="question-icon" id="questionIcon">🪐</div>
            <h2 id="questionText">Loading...</h2>
          </div>
          <div class="options-grid" id="optionsGrid"></div>
          <div class="feedback-box hidden" id="feedbackBox">
            <span id="feedbackIcon"></span>
            <p id="feedbackText"></p>
          </div>
          <button class="btn-primary btn-wide hidden" id="nextBtn" onclick="nextQuestion()">
            Pertanyaan Berikutnya ✦
          </button>
        </div>
      </div>

      <div class="kuis-screen hidden" id="resultScreen">
        <div class="kuis-card">
          <div class="kuis-card-icon" id="resultIcon">🏆</div>
          <h2 id="resultTitle">Luar Biasa!</h2>
          <p id="resultMessage">Kamu adalah penjelajah kosmik sejati!</p>
          <div class="score-display">
            <div class="final-score">
              <span id="finalScore">0</span>
              <small>/ <span id="maxScore">10</span></small>
            </div>
            <p>Jawaban Benar</p>
          </div>
          <div class="percent-ring">
            <svg viewBox="0 0 120 120">
              <circle cx="60" cy="60" r="50" fill="none" stroke="rgba(91,174,232,0.15)" stroke-width="10"/>
              <circle cx="60" cy="60" r="50" fill="none" stroke="var(--color-accent)" stroke-width="10"
                stroke-dasharray="314" stroke-dashoffset="314" id="percentCircle"
                stroke-linecap="round" transform="rotate(-90 60 60)"/>
            </svg>
            <span id="percentText">0%</span>
          </div>
          <div class="result-breakdown" id="resultBreakdown"></div>
          <div class="result-buttons">
            <button class="btn-primary" onclick="restartQuiz()">🔄 Ulangi Kuis</button>
            <a href="favorit.php" class="btn-secondary">⭐ Lihat Favorit</a>
          </div>
        </div>
      </div>

    </div>
  </main>

  <script src="navbar.js"></script>
  <script src="kuis.js"></script>
</body>
</html>