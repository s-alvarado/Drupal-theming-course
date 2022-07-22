(function ($, window, Drupal) {

    Drupal.behaviors.mentoring = {
      attach: function (context, settings) {
        let originalDate = 0;
        
        $('.year-badge', context).mouseenter(function () {
            // console.log("mouseenter");
            // We store the current slected element and its original inner html
            let currentElement = $(this);
            let currentValue = $(this).text().trim();
            // console.log("Element currentValue:", currentValue);

            // Generate and get the current year
            const d = new Date();
            let currentYear = parseInt(d.getFullYear(),10);
            // console.log("Current year:", currentYear, "OD:", originalDate);
            
            // Store current value in auxiliary variable
            originalDate = currentValue
            // console.log("Updated OD:", originalDate);

            // Parse curent value to integer
            currentValue = parseInt(currentValue,10);
            // console.log("Parsed current value:", currentValue);

            //Calculate year difference
            yearsDifference = (currentYear - currentValue).toString();
            // console.log("Year diff:", yearsDifference);

            //Replace current value displayed
            newValue = `${yearsDifference} Y`;
            // console.log("New value:", newValue);
            currentElement.text(newValue);

        }).mouseleave(function(){
            // console.log("mouseleave");
            // Restore the original value
            let currentElement = $(this);
            currentElement.text(originalDate)
        });

      }
    };
  
  })(jQuery, window, Drupal);
