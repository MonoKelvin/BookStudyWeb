$('.pagination').bootstrapPaginator({
    //设置版本号
    bootstrapMajorVersion: 3,
    // 显示第几页
    currentPage: 1,
    // 总页数
    totalPages: 10,
    itemTexts: function(type, page, current) {
        //控制每个操作按钮的显示文字。是个函数，有3个参数: type, page, current。
        //通过这个参数我们就可以将操作按钮上的英文改为中文，如first-->首页，last-->尾页。
        switch (type) {
            case 'first':
                return '首页';
            case 'prev':
                return '<';
            case 'next':
                return '>';
            case 'last':
                return '末页';
            case 'page':
                return page;
        }
    },
    //当单击操作按钮的时候, 执行该函数, 调用ajax渲染页面
    onPageClicked: function(event, originalEvent, type, page) {
        // 把当前点击的页码赋值给currentPage, 调用ajax,渲染页面
        currentPage = page;
        createBookTableItems(page);
    }
});
