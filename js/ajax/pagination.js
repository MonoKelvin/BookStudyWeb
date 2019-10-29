function createBookTableItems(page) {
    // 获取数据
    $.ajax({
        url: '../../api/book_pagination.php',
        type: 'get',
        data: {page : page},
        dataType: 'json',
        error: function() {
            alert('请求错误');
        },
        success: function(result) {
            if (result.code == 200) {
                $('#book-items-body').html(result.data['data']);
                item_per_page = result.data['item_pre_page'];
                var pages = Math.ceil(result.data['book_num'] / item_per_page);
                var options = {
                    bootstrapMajorVersion: 3,
                    currentPage: page,
                    numberOfPages: pages > 10 ? 10 : pages,
                    totalPages: pages,
                    itemTexts: function(type, page, current) {
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
                    onPageClicked: function(event, originalEvent, type, page) {
                        currentPage = page;
                        createBookTableItems(page);
                    }
                };
                $('#book-pagination1').bootstrapPaginator(options);
                $('#book-pagination2').bootstrapPaginator(options);
            } else {
                alert('请求失败，错误码：' + result.code);
            }
        }
    });
}

function createUserTableItems(page) {
    // 获取数据
    $.ajax({
        url: '../../api/user_pagination.php',
        type: 'get',
        data: { page: page },
        dataType: 'json',
        error: function() {
            alert('请求错误');
        },
        success: function(result) {
            if (result.code == 200) {
                $('#user-items-body').html(result.data['data']);
                item_per_page = result.data['item_pre_page'];
                var pages = Math.ceil(result.data['user_num'] / item_per_page);
                var options = {
                    bootstrapMajorVersion: 3,
                    currentPage: page,
                    numberOfPages: pages > 10 ? 10 : pages,
                    totalPages: pages,
                    itemTexts: function(type, page, current) {
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
                    onPageClicked: function(event, originalEvent, type, page) {
                        currentPage = page;
                        createUserTableItems(page);
                    }
                };
                $('#user-pagination1').bootstrapPaginator(options);
                $('#user-pagination2').bootstrapPaginator(options);
            } else {
                alert('请求失败，错误码：' + result.code);
            }
        }
    });
}
