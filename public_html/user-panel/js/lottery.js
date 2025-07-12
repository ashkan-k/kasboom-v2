// var lotterySection = document.querySelector('.lottery-section');
var minNumber = document.querySelector('.min-number');
var maxNumber = document.querySelector('.max-number');
var btnLottery = document.querySelector('.btn-lottery');
var winnerText = document.querySelector('.winner-text');
var LoadingWrapper = document.querySelector('.loading-wrapper');
var randonNumber = 0;

btnLottery.onclick = () => {
    LoadingWrapper.classList.add("active");
    setTimeout(() => {
        random(maxNumber.value);
    }, 2000);
}

function random(max) {
    randonNumber = Math.floor(Math.random() * max);
    winnerText.innerHTML = randonNumber;
    randonNumber = 0
    LoadingWrapper.classList.remove("active");
}