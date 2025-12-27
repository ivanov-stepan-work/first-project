$(document).ready(function () {
    window.showSuccessNotification = function(topic) {
        $('#alert-success').text(topic)
        $('#alert-success').removeClass('hide').addClass('show');
      
        // Скрыть уведомление через определенное время (например, 3 секунды)
        setTimeout(function() {
            hideSuccessNotification();
        }, 3000);
      }
      
      // Скрыть уведомление
      window.hideSuccessNotification = function() {
        $('#alert-success').removeClass('show').addClass('hide');
      }
      window.showErrorNotification = function(topic) {
        $('#alert-error-empty-topic').text(topic)
        $('#alert-error-empty-topic').removeClass('hide').addClass('show');
      
        // Скрыть уведомление через определенное время (например, 3 секунды)
        setTimeout(function() {
            hideErrorNotification();
        }, 3000);
      }
      
      // Скрыть уведомление
      window.hideErrorNotification = function() {
        $('#alert-error-empty-topic').removeClass('show').addClass('hide');
      }
});