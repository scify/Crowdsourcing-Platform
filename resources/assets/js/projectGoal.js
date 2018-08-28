let ProjectGoal = require('progressbar.js');

(function () {
    let displayProgressBar = function () {

        let progressBar = $("#progress-bar-circle");
        let bar = new ProjectGoal.Circle(progressBar[0], {
            color: '#0063aa',
            // This has to be the same size as the maximum width to
            // prevent clipping
            strokeWidth: 4,
            trailWidth: 2,
            easing: 'easeInOut',
            duration: 1400,
            text: {
                autoStyleContainer: false
            },
            from: {color: '#008AE5', width: 2},
            to: {color: '#008AE5', width: 4},
            // Set default step function for all animate calls
            step: function (state, circle) {
                circle.path.setAttribute('stroke', state.color);
                circle.path.setAttribute('stroke-width', state.width);

                let value = Math.round(circle.value() * 100);
                if (value === 0) {
                    circle.setText('0%');
                } else {
                    circle.setText(value + "%");
                }

            }
        });

        bar.text.style.fontSize = '2rem';
        bar.animate(progressBar.data("target") / 100);  // Number from 0.0 to 1.0

    };

    let init = function () {
        displayProgressBar();
    };

    init();
})();