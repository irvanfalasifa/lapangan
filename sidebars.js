$('.nav-link').click(function() {
  $('.nav-link').addClass('link-dark');
  $(this).removeClass('link-dark');
  let activeTab = $(this).attr('id');
  localStorage.setItem('activeTab', activeTab)
});

$(function() {
  let activeTab = localStorage.getItem('activeTab');
  document.getElementById(activeTab).click();
});