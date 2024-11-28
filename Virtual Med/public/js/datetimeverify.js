    // Get today's date in YYYY-MM-DD format
    const today = new Date().toISOString().split('T')[0];
    
    // Set minimum date to today
    document.getElementById('data').setAttribute('min', today);
    
    // Validate time if date is today
    document.getElementById('data').addEventListener('change', validateTime);
    document.getElementById('hora').addEventListener('change', validateTime);
    
    function validateTime() {
        const selectedDate = document.getElementById('data').value;
        const selectedTime = document.getElementById('hora').value;
        
        if(selectedDate === today) {
            const now = new Date();
            const currentHour = now.getHours();
            const currentMinutes = now.getMinutes();
            
            const [hours, minutes] = selectedTime.split(':');
            
            if(parseInt(hours) < currentHour || (parseInt(hours) === currentHour && parseInt(minutes) <= currentMinutes)) {
                alert('Please select a future time slot');
                document.getElementById('hora').value = '';
            }
        }
    }