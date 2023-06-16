
/**
 * 
 * useful links 
 * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/import
 */
 const passwordStrengthMeter = Object.freeze({
    containsUpperCase: (str) => /[A-Z]/.test(str),
    containsLowerCase: (str) => /[a-z]/.test(str),
    containsNumber: (str) => str.match(".*\\d.*"),
    containsSpecialChars: (str) => /[!@#£$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(str),
    is8Chars: (str) => str.length >= 8,
});

const setStrengthBar = ({
    currentValue = 0,
    colour = "danger",
    message = "weak",
}) => {

    const progressBar = document.querySelector(".progress-bar");
    progressBar.className = `progress-bar bg-${colour}`;
    progressBar.style.width = `${currentValue}%`;
    progressBar.innerText = `${currentValue}% ${message}`;
    progressBar.setAttribute('aria-valuenow', currentValue);

}
//https://javascript.plainenglish.io/why-you-should-avoid-switch-statements-in-javascript-ce07d5b60da4

const getProgressBar = (strength) => {
      const passwordMeterUI = {
        0: _ => setStrengthBar({ currentValue: 0, colour: "danger" }),
        1: _ => setStrengthBar({ currentValue: 20, colour: "danger", message: "this password is very weak!", }),
        2: _ => setStrengthBar({ currentValue: 40, colour: "warning", message: "this password is ok!", }),
        3: _ => setStrengthBar({ currentValue: 60, colour: "info", message: "this password is average!", }),
        4: _ => setStrengthBar({ currentValue: 80, colour: "dark", message: "this password is good!", }),
        5: _ => setStrengthBar({ currentValue: 100, colour: "success", message: "this password is excellent", }),
      };
      (passwordMeterUI[strength])();

};

const iconSize = new Map([ ['size', 30] ]);

const decreaseBar = `<svg xmlns="http://www.w3.org/2000/svg" width="${iconSize.get('size')}" height="${iconSize.get('size')}" fill="currentColor" class="bi bi-emoji-frown" viewBox="0 0 16 16">
<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
<path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
</svg>`;
const increaseBar = `<svg xmlns="http://www.w3.org/2000/svg" width="${iconSize.get('size')}" height="${iconSize.get('size')}" fill="currentColor" class="bi bi-emoji-smile" viewBox="0 0 16 16">
<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
<path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
</svg>`;


export { passwordStrengthMeter, setStrengthBar, getProgressBar, decreaseBar, increaseBar}

