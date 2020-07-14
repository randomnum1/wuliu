// 判断设备系统，若为IOS进行一次强制刷新
function judgeEquipment() {
    var u = navigator.userAgent;
    var app = navigator.appVersion;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1;
    // var isIOS = u.match(/iPad/) || u.match(/iPhone/) || u.match(/iPod/);
    var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
    // console.log(isIOS)
    // console.log(isAndroid)
    if (isAndroid) {
        // console.log("安卓")
    }
    if (isIOS) {
        // console.log('苹果');
        window.onpageshow = function(e) {
            if (e.persisted || (window.performance && window.performance.navigation.type == 2)) {
                window.location.reload()
            }
        }
    }
};

function getPublicUrl(urlList) {
    return new Promise((reslove, reject) => {
        axios.get('./static/json/default.json')
            .then((res) => {
                if (res.err) { reject(res.err) }
                for (key in urlList) {
                    urlList[key] = res.data.IP + res.data.project + urlList[key];
                }
                reslove(urlList)
            })
    })

};

function workgetPublicUrl(urlList) {
    return new Promise((reslove, reject) => {
        axios.get('../static/json/default.json')
            .then((res) => {
                if (res.err) { reject(res.err) }
                for (key in urlList) {
                    urlList[key] = res.data.IP + res.data.project + urlList[key];
                }
                reslove(urlList)
            })
    })

};

function getSearch() {
    return new Promise((reslove, reject) => {
        var name, value;
        // var str = "http://10.102.10.33:5500/detail.html?recordId=94"
        var str = decodeURI(location.href); //取得整个地址栏
        var num = str.indexOf("?")
        str = str.substr(num + 1); //取得所有参数   stringvar.substr(start [, length ]
        var arr = str.split("&"); //各个参数放到数组里
        var obj = {};
        for (var i = 0; i < arr.length; i++) {
            num = arr[i].indexOf("=");
            var name = arr[i].substring(0, num);
            var value = arr[i].slice(num + 1);
            obj[name] = value;
        }
        reslove(obj);
    })
};

function copy(item) {
    // 获取需要复制的文字
    const copyStr = item;
    // 创建input标签存放需要复制的文字
    const oInput = document.createElement('input');
    // 把文字放进input中，供复制
    oInput.value = copyStr;
    document.body.appendChild(oInput);
    // 选中创建的input
    oInput.select();
    // 执行复制方法， 该方法返回bool类型的结果，告诉我们是否复制成功
    const copyResult = document.execCommand('copy')
        // 操作中完成后 从Dom中删除创建的input
    document.body.removeChild(oInput)
        // 根据返回的复制结果 给用户不同的提示
    if (copyResult) {
        message.success('DDL已复制到粘贴板')
    } else {
        message.error('复制失败')
    }
}