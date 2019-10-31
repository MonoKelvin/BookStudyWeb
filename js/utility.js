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

function sendVerifyCodeMail(mailInputObj) {
    var mailReg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    if (!mailReg.test(mailInputObj.val())) {
        alert('请输入正确的邮件地址');
        mailInputObj.focus();
        return;
    }
    $.ajax({
        url: '/../api/phpmailer_api.php',
        type: 'post',
        data: {
            submit: 'get_verify_code',
            email: mailInputObj.val()
        },
        dataType: 'json',
        error: function() {
            alert('邮件发送失败，请重新发送邮件！');
        },
        success: function(result) {
            if (result.code == 200) {
                alert('邮件发送成功，请注意查收！');
            } else {
                alert('发送邮件失败，请重新发送邮件！');
            }
        }
    });
}
