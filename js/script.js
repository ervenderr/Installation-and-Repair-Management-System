
const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-next");
const progress = document.getElementById("progress");
const formSteps = document.querySelectorAll(".form-step");
const progressSteps = document.querySelectorAll(".progress-step");

let formStepsNum = 0;

nextBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    if (validateFormStep()) {
      formStepsNum++;
      updateFormSteps();
      updateProgressBar();
    }
  });
});


function validateFormStep() {
  const inputs = formSteps[formStepsNum].querySelectorAll("input");
  let isValid = true;

  inputs.forEach((input) => {
    if (input.name === "mname") {
      return;
    }
    if (!input.value) {
      input.nextElementSibling.innerHTML = "This field is required.";
      isValid = false;
    } else if (input.name === "email") {
      if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(input.value)) {
        input.nextElementSibling.innerHTML = "Please enter a valid email.";
        isValid = false;
      } else {
        input.nextElementSibling.innerHTML = "";
      }
    } else if (input.name === "phone") {
      if (!/^[0-9]{11}$/.test(input.value)) {
        input.nextElementSibling.innerHTML = "Please enter a valid phone number in the format 09xxxxxxxxx";
        isValid = false;
      } else {
        input.nextElementSibling.innerHTML = "";
      }
    } else {
      input.nextElementSibling.innerHTML = "";
    }
  });

  return isValid;
}



prevBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    formStepsNum--;
    updateFormSteps();
    updateProgressBar();
  });
});

function updateFormSteps() {
  formSteps.forEach((formStep) => {
    formStep.classList.contains("form-step-active") &&
      formStep.classList.remove("form-step-active");
  });

  formSteps[formStepsNum].classList.add("form-step-active");
}

function updateProgressBar() {
  progressSteps.forEach((progressStep, idx) => {
    if (idx < formStepsNum + 1) {
      progressStep.classList.add("progress-step-active");
    } else {
      progressStep.classList.remove("progress-step-active");
    }
  });

  const progressActive = Array.from(document.querySelectorAll(".progress-step-active"));

  progress.style.width =
    ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
}





// homepage
// Select The Elements
var toggle_btn;
var big_wrapper;
var hamburger_menu;

function declare() {
  toggle_btn = document.querySelector(".toggle-btn");
  big_wrapper = document.querySelector(".big-wrapper");
  hamburger_menu = document.querySelector(".hamburger-menu");
}

const main = document.querySelector("main");

declare();

let dark = false;

function toggleAnimation() {
  // Clone the wrapper
  dark = !dark;
  let clone = big_wrapper.cloneNode(true);
  if (dark) {
    clone.classList.remove("light");
    clone.classList.add("dark");
  } else {
    clone.classList.remove("dark");
    clone.classList.add("light");
  }
  clone.classList.add("copy");
  main.appendChild(clone);

  document.body.classList.add("stop-scrolling");

  clone.addEventListener("animationend", () => {
    document.body.classList.remove("stop-scrolling");
    big_wrapper.remove();
    clone.classList.remove("copy");
    // Reset Variables
    declare();
    events();
  });
}

function events() {
  toggle_btn.addEventListener("click", toggleAnimation);
  hamburger_menu.addEventListener("click", () => {
    big_wrapper.classList.toggle("active");
  });
}
events();

