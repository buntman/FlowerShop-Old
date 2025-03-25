

document.addEventListener("DOMContentLoaded", function () {
  const showAllBtn = document.getElementById("showAll");
  const showUnreadBtn = document.getElementById("showUnread");
  const markAsReadBtn = document.getElementById("markAsRead");




  function toggleActiveButton(activeButton) {
    // Remove bg-btn from "All" and "Unread" buttons
    document.querySelectorAll("#showAll, #showUnread").forEach(btn => btn.classList.remove("bg-btn"));
    // Add bg-btn to the clicked button
    activeButton.classList.add("bg-btn");
  }



  function updateUnreadCount() {
    let unreadNotifications = document.querySelectorAll(".notification-unread").length;
    document.querySelector(".page-title-notifications p").innerHTML = `You've ${unreadNotifications} unread notification${unreadNotifications !== 1 ? 's' : ''}`;
  }

  // Toggle "notification-active" class on click
  document.querySelectorAll(".notification-item").forEach(row => {
    row.addEventListener("click", function () {
      this.classList.toggle("notification-active");
    });
  });

  // Show unread notifications only
  showUnreadBtn.addEventListener("click", function () {
    document.querySelectorAll(".notification-item").forEach(item => {
      const textContainer = item.querySelector(".text-container");
      item.style.display = textContainer.classList.contains("notification-unread") ? "flex" : "none";
    });
    toggleActiveButton(this);
  });

  // Show all notifications
  showAllBtn.addEventListener("click", function () {
    document.querySelectorAll(".notification-item").forEach(item => {
      item.style.display = "flex";
    });
    toggleActiveButton(this);
  });

  // Mark all as read
  markAsReadBtn.addEventListener("click", function () {
    document.querySelectorAll(".text-container.notification-unread").forEach(element => {
      element.classList.remove("notification-unread");
    });
    updateUnreadCount();
  });

  // Delete a notification
  document.addEventListener("click", function (event) {
    if (event.target.closest(".delete-btn")) {
      event.target.closest(".notification-item").remove();
      updateUnreadCount();
    }
  });

  updateUnreadCount(); // Update unread count on page load
});