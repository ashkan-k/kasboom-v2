const background = document.querySelector('#background');
const thumbnail = document.querySelector('#thumbnail');
const song = document.querySelector('#song');
const songTitle = document.querySelector('.track-name');
const songArtist = document.querySelector('.track-artist');
const songmegabite = document.querySelector('.track-mb');
const progressBar = document.querySelector('#progress-bar');
const linkDownloadPodcast = document.querySelector('#link-download-podcast');

let pPause = document.querySelector('#play-pause');
if (document.getElementById('playList') !== null) {
    var playlist = document.getElementById('playList');
    var soundItem = playlist.querySelectorAll('.sound-item');
    soundItem.forEach(item => {
        item.addEventListener('click', function () {
            song.src = item.dataset.url;
            thumbnail.src = item.dataset.img;
            songArtist.innerHTML = item.dataset.voice;
            songTitle.innerHTML = item.dataset.name;
            songmegabite.innerHTML = item.dataset.mb;
            linkDownloadPodcast.href = item.dataset.url;
            playing = true;
            playPause();
        });
    });
}
songIndex = 0;

let playing = true;
function playPause() {
    if (playing) {
        const song = document.querySelector('#song'),
            thumbnail = document.querySelector('#thumbnail');
        pPause.classList.add('isPlaying');
        song.play();
        playing = false;
    } else {
        pPause.classList.remove('isPlaying');
        song.pause();
        playing = true;
    }
}

song.addEventListener('ended', function () {
    nextSong();
});

function nextSong() {
    songIndex++;
    if (songIndex > soundItem.length - 1) {
        songIndex = 0;
    };
    song.src = soundItem[songIndex].dataset.url;
    thumbnail.src = soundItem[songIndex].dataset.img;
    songArtist.innerHTML = soundItem[songIndex].dataset.name;
    songTitle.innerHTML = soundItem[songIndex].dataset.voice;
    songmegabite.innerHTML = soundItem[songIndex].dataset.mb;
    playing = true;
    playPause();
}
function previousSong() {
    songIndex--;
    if (songIndex < 0) {
        songIndex = 1;
    };
    song.src = soundItem[songIndex].dataset.url;
    thumbnail.src = soundItem[songIndex].dataset.img;
    songArtist.innerHTML = soundItem[songIndex].dataset.name;
    songTitle.innerHTML = soundItem[songIndex].dataset.voice;
    songmegabite.innerHTML = soundItem[songIndex].dataset.mb;
    playing = true;
    playPause();
}
function updateProgressValue() {
    progressBar.max = song.duration;
    progressBar.value = song.currentTime;
    document.querySelector('.currentTime').innerHTML = (formatTime(Math.floor(song.currentTime)));
    if (document.querySelector('.durationTime').innerHTML === "NaN:NaN") {
        document.querySelector('.durationTime').innerHTML = "0:00";
    } else {
        document.querySelector('.durationTime').innerHTML = (formatTime(Math.floor(song.duration)));
    }
};
function formatTime(seconds) {
    let min = Math.floor((seconds / 60));
    let sec = Math.floor(seconds - (min * 60));
    if (sec < 10) {
        sec = `0${sec}`;
    };
    return `${min}:${sec}`;
};
setInterval(updateProgressValue, 500);

function changeProgressBar() {
    song.currentTime = progressBar.value;
};