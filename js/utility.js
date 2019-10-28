function dateFormat(fmt, date) {
    let ret;
    let opt = {
        'y+': date.getFullYear().toString(), // 年
        'M+': (date.getMonth() + 1).toString(), // 月
        'd+': date.getDate().toString(), // 日
        'h+': date.getHours().toString(), // 时
        'm+': date.getMinutes().toString(), // 分
        's+': date.getSeconds().toString() // 秒
        // 有其他格式化字符需求可以继续添加，必须转化成字符串
    };
    for (let k in opt) {
        ret = new RegExp('(' + k + ')').exec(fmt);
        if (ret) {
            fmt = fmt.replace(ret[1], ret[1].length == 1 ? opt[k] : opt[k].padStart(ret[1].length, '0'));
        }
    }
    return fmt;
}

function addTag() {
    let tag = $('#input-add-tag')
        .val()
        .toString();
    tag = tag.replace(',', ' ');
    if (tag && tag.split(' ').join('').length > 0) {
        // 如果标签不存在，就添加新的
        if (tags.indexOf(tag) == -1) {
            tags.push(tag);

            let domStr = '<span class="label label-info m-1">' + tag;
            domStr += '<a onclick="deleteTag(this);" class="text-white pl-2" style="cursor:pointer">';
            domStr += '<i class="fa fa-trash"></i></a></span>';

            var tmpDiv = document.createElement('div');
            tmpDiv.innerHTML = domStr;
            document.getElementById('add-tag-container').appendChild(tmpDiv.childNodes[0]);

            $('#input-add-tag').val('');
        } else {
            alert('标签已经存在！');
            $('#input-add-tag').val('');
            return;
        }
    }
}

function deleteTag(obj) {
    let parent = obj.parentNode.parentNode;
    parent.removeChild(obj.parentNode);
    tags.remove(obj.parentNode.innerText);
}

function changeBookImage(obj) {
    var file = obj.files && obj.files.length > 0 ? obj.files[0] : null;

    if (!file) {
        return;
    }
    if (file.size >= 1 * 1024 * 1024) {
        alert('文件不允许大于1M');
        return;
    }
    if (file.type !== 'image/png' && file.type !== 'image/jpg' && file.type !== 'image/jpeg') {
        alert('文件格式必须为：png/jpg/jpeg');
        return;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
        var data = e.target.result;
        var bookImg = $('#book-image');
        bookImg.attr('src', data);
        $('#tmp-file-input').attr('value', data);
    };
    reader.readAsDataURL(file);
    return;
}
