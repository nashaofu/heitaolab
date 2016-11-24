var examples = document.getElementById('examples');
var addboxMask = document.getElementById('addbox-mask');
var addBox = document.getElementById('addbox');
var addExample = document.getElementById('addexample');
var closeBtn = document.getElementById('close');
var btnbarBtn = document.getElementById('btn-bar').getElementsByTagName('a');
var section = document.getElementsByClassName('section');
var ExaName = document.getElementById('example-name');
var ExaUrl = document.getElementById('example-url');
var iframe = document.getElementById('iframe');
var iframesrc = iframe.src;
var okBtn = document.getElementById('ok');
var cancelBtn = document.getElementById('cancel');
var ExaNameVal;
var ExaUrlVal;
var okMode = 'add';
//最多实例个数
var MaxexampleLengt = 5;
addExample.onclick = function() {
    if (iframe.src != iframesrc) {
        iframe.src = iframesrc;
    }
    if (examples.childNodes.length > MaxexampleLengt - 1) {
        alert('只能添加' + MaxexampleLengt + '个实例');
        return false;
    }
    ExaUrl.disabled = false;
    addboxMask.style.display = 'block';
    addBox.style.display = 'block';
    tabswitch(0);
    ExaNameVal = '';
    ExaUrlVal = '';
    ExaName.value = '';
    ExaUrl.value = '';
    okMode = 'add';
}
okBtn.onclick = function() {
    dialogOk(okMode);
}
closeBtn.onclick = function() {
    dialogClose('CLOSE');
}
cancelBtn.onclick = function() {
    dialogClose('CLOSE');
}
for (var i = 0; i < btnbarBtn.length; i++) {
    btnbarBtn[i].index = i;
    btnbarBtn[i].onclick = function() {
        tabswitch(this.index);
    }
}

function dialogOk(mode) {
    if (ExaName.value != '' && ExaUrl.value != '') {
        if (mode == 'add') {
            AddExample(ExaName.value, ExaUrl.value, ExaUrl.disabled);
        } else {
            EditExample(ExaName.value, ExaUrl.value, ExaUrl.disabled);
        }
        dialogClose('OK');
    } else if (ExaName.value == '') {
        alert('实例名称不能为空');
    } else if (ExaUrl.value == '') {
        alert('URL不能为空');
    } else {
        alert('缺少实例资源');
    }
}

function dialogClose(mode) {
    if (mode == 'CLOSE') {
        if (ExaName.value != ExaNameVal || ExaUrl.value != ExaUrlVal) {
            if (confirm('部分修改内容尚未保存,是否确认关闭对话框?')) {
                ExaName.value = ExaNameVal;
                ExaUrl.value = ExaUrlVal;
            } else {
                return;
            }
        }
        addboxMask.style.display = 'none';
        addBox.style.display = 'none';
        iframe.src = '';
        tabswitch(0);
    } else {
        addboxMask.style.display = 'none';
        addBox.style.display = 'none';
        iframe.src = '';
        tabswitch(0);
        ExaName.value = '';
        ExaUrl.value = '';
    }
}

function tabswitch(index) {
    for (var i = 0; i < btnbarBtn.length; i++) {
        btnbarBtn[i].style.backgroundColor = '#eee';
        btnbarBtn[i].style.backgroundImage = 'linear-gradient(to bottom,#fafafa,#ededed)';
        btnbarBtn[i].style.borderBottomColor = '#cacaca';
        section[i].style.display = 'none';
    }
    section[index].style.display = 'block';
    btnbarBtn[index].style.backgroundColor = '#fff';
    btnbarBtn[index].style.backgroundImage = 'none';
    btnbarBtn[index].style.borderBottomColor = '#fff';
}

function get(name, url) {
    ExaName.value = name;
    ExaUrl.value = url;
    ExaUrl.disabled = true;
    tabswitch(0);
    iframe.src = iframesrc;
}
var thisNode;

function AddExample(name, url, disabledVal) {
    //新实例
    var newExample = document.createElement("div");
    newExample.setAttribute('style', 'width:auto;height:36px;line-height:36px;margin: 0;');
    //生成两个input,存储name和url
    var ExampleName = document.createElement("input");
    ExampleName.className = 'Example_Name';
    ExampleName.type = 'hidden';
    ExampleName.name = 'ExampleName[]';
    ExampleName.value = name;
    var ExampleUrl = document.createElement("input");
    ExampleUrl.className = 'Example_Url';
    ExampleUrl.type = 'hidden';
    ExampleUrl.name = 'ExampleUrl[]';
    ExampleUrl.value = url;
    //显示的实例列表
    var nExample = document.createElement("div");
    nExample.setAttribute('style', 'position:relative;background-color:#efcf33;background-image:linear-gradient(to bottom,#efcf33,#ffcf33);padding: 0 5px;border-radius: 4px;');
    var nExampleTxt = document.createElement('div');
    var nExampleBtn = document.createElement("a");
    //显示区的实例属性
    nExampleTxt.text = name;
    nExampleTxt.url = url;
    nExampleTxt.disabledVal = disabledVal;
    nExampleTxt.className = 'Example_Txt';
    nExampleTxt.setAttribute('style', 'width:auto;height:24px;line-height:24px;margin:3px 20px 3px 0;padding:3px 0;font-size:17px;cursor:pointer;overflow:hidden;text-overflow:ellipsis;word-wrap:break-word;white-space:nowrap;border-radius: 3px;');
    nExampleBtn.href = 'javascript:void(0)';
    nExampleBtn.title = '移除';
    nExampleBtn.setAttribute('style', 'width:5px;height:5px;display:block;float:right;background-color:#fff;background-image:url(/images/tool/close.png);border-color:#fff;background-repeat:no-repeat;background-position:center;background-size:cover;border-radius:50%;border:none;margin:-6.5px 5px;padding:4px;position:absolute;right:0;top:50%;');
    nExampleBtn.onmouseover = function() {
        nExampleBtn.style.width = '8px';
        nExampleBtn.style.height = '8px';
        nExampleBtn.style.margin = '-8px 3.5px';
    }
    nExampleBtn.onmouseout = function() {
        nExampleBtn.style.width = '5px';
        nExampleBtn.style.height = '5px';
        nExampleBtn.style.margin = '-6.5px 5px';
    }
    nExampleBtn.onclick = function() {
        this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);
    }
    nExampleTxt.appendChild(document.createTextNode(nExampleTxt.text));
    nExample.appendChild(nExampleTxt);
    nExample.appendChild(nExampleBtn);
    nExampleTxt.onclick = function() {
        if (iframe.src != iframesrc) {
            iframe.src = iframesrc;
        }
        addboxMask.style.display = 'block';
        addBox.style.display = 'block';
        tabswitch(0);
        ExaName.value = this.text;
        ExaNameVal = this.text;
        ExaUrl.value = this.url;
        ExaUrlVal = this.url;
        ExaUrl.disabled = this.disabledVal;
        okMode = 'edit';
        thisNode = this.parentNode.parentNode;
    }
    newExample.appendChild(ExampleName);
    newExample.appendChild(ExampleUrl);
    newExample.appendChild(nExample);
    examples.appendChild(newExample);
    addboxMask.style.display = 'none';
    addBox.style.display = 'none';
    iframe.src = '';
    tabswitch(0);
}

function EditExample(name, url) {
    var exampleName = thisNode.getElementsByClassName('Example_Name')[0];
    var exampleUrl = thisNode.getElementsByClassName('Example_Url')[0];
    var exampleTxt = thisNode.getElementsByClassName('Example_Txt')[0];
    exampleName.value = name;
    exampleUrl.value = url;
    exampleTxt.text = name;
    exampleTxt.url = url;
    exampleTxt.innerHTML = exampleTxt.text;
    thisNode = '';
}