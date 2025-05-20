// Main JavaScript file for Quiz System

document.addEventListener('DOMContentLoaded', function() {
    // Flash messages auto-close
    const flashMessages = document.querySelectorAll('.alert:not(.alert-danger)');
    flashMessages.forEach(function(flash) {
        setTimeout(function() {
            // Fade out
            flash.style.opacity = '0';
            flash.style.transition = 'opacity 0.5s ease';
            
            // Remove after transition
            setTimeout(function() {
                flash.remove();
            }, 500);
        }, 4000);
    });
    
    // Answer option selection for tests
    const answerOptions = document.querySelectorAll('.answer-option');
    answerOptions.forEach(function(option) {
        option.addEventListener('click', function() {
            // Get the radio input within this option
            const radio = option.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                
                // Remove selected class from all options in this question group
                const questionId = radio.name.split('_')[1];
                document.querySelectorAll(`input[name="question_${questionId}"]`).forEach(function(input) {
                    const parentOption = input.closest('.answer-option');
                    if (parentOption) {
                        parentOption.classList.remove('selected');
                    }
                });
                
                // Add selected class to this option
                option.classList.add('selected');
            }
        });
    });
    
    // Form validation for required fields
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    
                    // Create or update feedback message
                    let feedback = field.nextElementSibling;
                    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                        feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        field.parentNode.insertBefore(feedback, field.nextSibling);
                    }
                    feedback.textContent = 'This field is required.';
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
    
    // Confirmation dialogs for delete actions
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                event.preventDefault();
            }
        });
    });
    
    // Test timer functionality
    const timerElement = document.getElementById('test-timer');
    if (timerElement) {
        const duration = parseInt(timerElement.getAttribute('data-duration'), 10) || 0;
        
        if (duration > 0) {
            let timeLeft = duration * 60; // Convert to seconds
            
            const timerInterval = setInterval(function() {
                timeLeft--;
                
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                
                timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                
                // Add warning class when time is running out
                if (timeLeft < 60) {
                    timerElement.classList.add('text-danger');
                }
                
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    // Auto-submit form when time is up
                    document.getElementById('test-form').submit();
                }
            }, 1000);
        }
    }
});
