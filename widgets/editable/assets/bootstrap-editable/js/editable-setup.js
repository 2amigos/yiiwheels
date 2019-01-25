/**
 * Script which should prevent accumulation of same events.
 */

window.WhEditableSetup = window.WhEditableSetup || {
    _targets: {},
    _initialized: false,
    _initialize: function() {
        if (this._initialized) {
            return;
        }

        var targets = this._targets;

        $('body').on('ajaxUpdate.editable', function(e) {
            for(var target in targets) {
                if (!targets.hasOwnProperty(target)) {
                    continue;
                }

                var targetInfo = targets[target];

                if (e.target.id == targetInfo.target) {
                    targetInfo.runner();
                }
            }
        });

        this._initialized = true;
    },
    set: function(widgetId, target, runner) {
        this._initialize();
        this._targets[widgetId] = {target: target, runner: runner};
        runner();
    }
};
