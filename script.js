const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-next");
const progress = document.getElementById("progress");
const formSteps = document.querySelectorAll(".form-step");
const progressSteps = document.querySelectorAll(".progress-step");

let formStepsNum = 0;

nextBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
      formStepsNum++;
      updateFormSteps();
      updateProgressBar();
  });
});

prevBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
      formStepsNum--;
      updateFormSteps();
      updateProgressBar();
  });
});

function updateFormSteps(){
  formSteps.forEach((formSteps) => {
    formSteps.classList.contains("form-step-active") && 
    formSteps.classList.remove("form-step-active");
  });


  formSteps[formStepsNum].classList.add("form-step-active");
}

function updateProgressBar(){
  progressSteps.forEach((progressStep, idx) =>{
    if(idx < formStepsNum + 1){
      progressStep.classList.add("progress-step-active")
    }else{
      progressStep.classList.remove("progress-step-active")
    }
  });

  const progressActive = document.querySelectorAll(".progress-step-active");

  progress.style.width = 
    ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
}

