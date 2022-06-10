import ProjectGoal from 'progressbar.js';

(function () {
    let displayProgressBar = function () {
        let progressBarElements = $(".progress-bar-circle");
        progressBarElements.each(function (index) {
            const elementId = $(this).attr('id');
            const color = $(this).data('color') ?? '#0077FF';
            let bar = new ProjectGoal.Circle('#' + elementId, {
                color: color,
                // This has to be the same size as the maximum width to
                // prevent clipping
                strokeWidth: 4,
                trailWidth: 2,
                easing: 'easeInOut',
                duration: 1400,
                text: {
                    autoStyleContainer: false
                },
                svgStyle: {
                    display: 'absolute',
                    width: '120px'
                },
                from: {color: color, width: 2},
                to: {color: color, width: 4},
                // Set default step function for all animate calls
                step: function (state, circle) {
                    circle.path.setAttribute('stroke', state.color);
                    circle.path.setAttribute('stroke-width', state.width);

                    let value = Math.round(circle.value() * 100);
                    circle.setText(value + '%');
                }
            });
            bar.text.style.fontSize = '2rem';
            bar.animate($(this).data("target") / 100);
        });

    };

    let init = function () {
        //displayProgressBar();

    };
    $(document).ready(function () {
        init();
    });
})();
