var clsPatchworks = Class.create();
var patchworksCls = Array();

clsPatchworks.prototype = {
    initialize: function(id) {
        this.id = id;
        this.currentPatchworksID = null;
        this.patchworks_id = null;
    },
checkCurrent: function() {
    var current = $("patchworks_current" + this.currentPatchworksID + this.id);
    current.checked = true;
    },
    changeCurrent: function(patchworksID) {
        var oldCurrentRow = $("patchworks_current_row_" + this.currentPatchworksID + this.id);
        if (oldCurrentRow) {
            Element.removeClassName(oldCurrentRow, "highlight");
        }

        this.currentPatchworksID = patchworksID;
        var currentRow = $("patchworks_current_row_" + this.currentPatchworksID + this.id);
        Element.addClassName(currentRow, "highlight");

        var post = {
            "action":"patchworks_action_edit_current",
            "patchworks_id":patchworksID
        };
        var params = new Object();
        params["callbackfunc_error"] = function(res){
                                            commonCls.alert(res);
                                            commonCls.sendView(this.id, "patchworks_view_edit_list");
                                        }.bind(this);
        commonCls.sendPost(this.id, post, params);
    },
    postMain: function() {
        var post = {
            "action":"patchworks_action_main_post",
        };
    
        var params = new Object();
        commonCls.sendPost(this.id, post,params);
    }

}
