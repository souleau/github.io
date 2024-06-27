document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('myAudio');
    const playPauseBtn = document.getElementById('playPauseBtn');
    const skipBtn = document.getElementById('skipBtn');
    const backBtn = document.getElementById('backBtn');
    const progressBar = document.getElementById('progressBar');
    const volumeRange = document.getElementById('volumeRange');

    playPauseBtn.addEventListener('click', function() {
        if (audio.paused) {
            audio.play();
            playPauseBtn.textContent = '||';
        } else {
            audio.pause();
            playPauseBtn.textContent = '>';
        }
    });

    skipBtn.addEventListener('click', function() {
        audio.currentTime += 10; // skip 10 seconds
    });

    backBtn.addEventListener('click', function() {
        audio.currentTime -= 10; // back 10 seconds
    });

    audio.addEventListener('timeupdate', function() {
        progressBar.value = (audio.currentTime / audio.duration) * 100;
    });

    progressBar.addEventListener('input', function() {
        audio.currentTime = (progressBar.value / 100) * audio.duration;
    });

    volumeRange.addEventListener('input', function() {
        audio.volume = volumeRange.value;
    });
});
