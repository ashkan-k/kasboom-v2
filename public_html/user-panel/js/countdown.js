var daraArray = [];
var finaleDate = [];

if (document.querySelector('.countdown-title') !== null) {
    var countdownTitle = document.querySelector('.countdown-title')
}
const timer = () => {
    const now = new Date().getTime();
    let diff = finaleDate - now;
    if (diff < 0) {
        document.querySelector('.countdown-alert').style.display = 'inline-block';
        document.querySelector('.countdown-inner').style.display = 'none';
        countdownTitle.style.display = 'none';
    }

    let days = Math.floor(diff / (1000 * 60 * 60 * 24));
    let hours = Math.floor(diff % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
    let minutes = Math.floor(diff % (1000 * 60 * 60) / (1000 * 60));
    let seconds = Math.floor(diff % (1000 * 60) / 1000);

    days <= 99 ? days = `${days}` : days;
    days <= 9 ? days = `${days}` : days;
    hours <= 9 ? hours = `0${hours}` : hours;
    minutes <= 9 ? minutes = `0${minutes}` : minutes;
    seconds <= 9 ? seconds = `0${seconds}` : seconds;

    document.querySelector('#days').textContent = days;
    document.querySelector('#hours').textContent = hours;
    document.querySelector('#minutes').textContent = minutes;
    document.querySelector('#seconds').textContent = seconds;

}

if (document.querySelectorAll('.countdown-content') !== null) {
    var countdownContent = document.querySelectorAll('.countdown-content');

    countdownContent.forEach((time, i) => {
        daraArray[i] = time.dataset.time;
        finaleDate[i] = new Date(`${daraArray[i]}`).getTime();
        timer(finaleDate[i]);
    });

}

setInterval(timer, 1000);
