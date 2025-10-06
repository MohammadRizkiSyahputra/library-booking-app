document.addEventListener("DOMContentLoaded", () => {
  const resendLink = document.getElementById("resendLink");
  const cooldownTimer = document.getElementById("cooldownTimer");
  if (!resendLink || !cooldownTimer) return;

  let cooldown = 60; // seconds
  resendLink.classList.add("pointer-events-none", "opacity-50");
  cooldownTimer.classList.remove("hidden");

  const countdown = setInterval(() => {
    cooldown--;
    cooldownTimer.textContent = `(${cooldown}s)`;

    if (cooldown <= 0) {
      clearInterval(countdown);
      resendLink.classList.remove("pointer-events-none", "opacity-50");
      cooldownTimer.classList.add("hidden");
    }
  }, 1000);
});
