if (document.getElementById('design-form')) {
    var designFormbox = document.getElementById('design-form');
    var inputbox = document.getElementById('input-box').getElementsByTagName('input');
    var outputbox = document.getElementById('output-box').getElementsByTagName('input');
    var Warnbox = document.getElementsByClassName('warn');

    function designCheck() {
        var WarnInputshow = true;
        var WarnOutputshow = true;
        for (var i = 0; i < inputbox.length; i++) {
            if (inputbox[i].checked == true) {
                WarnInputshow = false;
                break;
            }
        }
        for (var i = 0; i < outputbox.length; i++) {
            if (outputbox[i].checked == true) {
                WarnOutputshow = false;
                break;
            }
        }
        if (WarnInputshow) {
            Warnbox[0].style.display = 'block';
        } else {
            Warnbox[0].style.display = 'none';
        }
        if (WarnOutputshow) {
            Warnbox[1].style.display = 'block';
        } else {
            Warnbox[1].style.display = 'none';
        }
        if (!WarnInputshow && !WarnOutputshow) {
            return true;
        } else {
            return false;
        }
    }
    designFormbox.onsubmit = function() {
        return designCheck();
    }
}
if (publishForm = document.getElementById('publish-form')) {
    var publishForm = document.getElementById('publish-form');
    var artilcleTitle = document.getElementById('article-title');
    var artilcleInput = document.getElementById('article-input').getElementsByTagName('input');
    var artilcleOutput = document.getElementById('article-output').getElementsByTagName('input');
    var articleSummary = document.getElementById('article-summary');
    var articleBody = CKEDITOR.instances.editor;
    var Warnbox = document.getElementsByClassName('warn');

    function publishCkeck() {
        if (artilcleTitle.value == '') {
            Warnbox[0].style.display = 'block';
            return false;
        } else {
            Warnbox[0].style.display = 'none';
        }
        var WarnInputshow = true;
        var WarnOutputshow = true;
        for (var i = 0; i < artilcleInput.length; i++) {
            if (artilcleInput[i].checked == true) {
                WarnInputshow = false;
                break;
            }
        }
        if (WarnInputshow) {
            Warnbox[1].style.display = 'block';
            return false;
        } else {
            Warnbox[1].style.display = 'none';
        }
        for (var i = 0; i < artilcleOutput.length; i++) {
            if (artilcleOutput[i].checked == true) {
                WarnOutputshow = false;
                break;
            }
        }
        if (WarnOutputshow) {
            Warnbox[2].style.display = 'block';
            return false;
        } else {
            Warnbox[2].style.display = 'none';
        }
        if (articleSummary.value == '') {
            Warnbox[3].style.display = 'block';
            return false;
        } else {
            Warnbox[3].style.display = 'none';
        }
        if (articleBody.getData() == '') {
            Warnbox[4].style.display = 'block';
            return false;
        } else {
            Warnbox[4].style.display = 'none';
        }
        return true;
    }
    publishForm.onsubmit = function() {
        return publishCkeck();
    }
}