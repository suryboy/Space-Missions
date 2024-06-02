$(document).ready(function() {
    // Initialize resizable
    $('.log-panel').resizable({
        handles: 'e', // 'e' for east (right)
        resize: function(event, ui) {
            var logPanelWidth = ui.size.width;
            var missionPanelWidth = $('.mission-list').width() + 50;
            var missionInfoPanelWidth = $(window).width() - missionPanelWidth - logPanelWidth;
            
            // Set the width of the mission-info-panel to the remaining space
            $('.mission-info-panel').width(missionInfoPanelWidth);

            // Check if mission-info-panel has reached its limit
            if (missionInfoPanelWidth <= 320) { // Adjust the limit as needed
                $('.log-panel').resizable('option', 'maxWidth', logPanelWidth); // Set max width to current width
            } else {
                $('.log-panel').resizable('option', 'maxWidth', null); // Remove max width limit
            }
        }
    });

    $("#test").CreateMultiCheckBox({ width: '230px', defaultText : 'Select Below', height:'250px' });
});

document.addEventListener('DOMContentLoaded', function() {
    const employeeList = document.getElementById('employee-list');
    const employeePosition = document.getElementById('employee-position');
    const employeeAge = document.getElementById('employee-age');
    const employeeStatsInfo = document.getElementById('employee-stats-info');

    employeeList.addEventListener('change', function() {
        const selectedOption = employeeList.options[employeeList.selectedIndex];
        const position = selectedOption.getAttribute('data-position');
        const age = selectedOption.getAttribute('data-age');

        employeeStatsInfo.style.display = 'none'; // Hide the initial info text
        employeePosition.textContent = `Qualification: ${position}`;
        employeeAge.textContent = `Age: ${age}`;
    });
});