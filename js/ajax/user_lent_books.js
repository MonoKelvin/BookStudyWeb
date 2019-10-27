document.write('<script src="js/utility.js"></script>');

function createUserLentBookItems(id) {
    $.ajax({
        url: '../../api/user_lent_books.php?id=' + id,
        type: 'get',
        dataType: 'json',
        error: function() {
            alert('请求错误');
        },
        success: function(result) {
            if (result.code == 200) {
                var html = '';
                $.each(result.data, function(key, value) {
                    html += '<tr>';
                    html += '<td class="text-center">' + value['b_id'] + '</td>';
                    html += '<td class="text-center">' + value['title'] + '</td>';
                    html += '<td class="text-center">' + value['author'] + '</td>';

                    var lent_time = new Date(value['lent_time']);
                    html += '<td class="text-center">' + dateFormat('yyyy-MM-dd hh:mm:ss', lent_time) + '</td>';
                    lent_time.setTime(lent_time.getTime() + 1000 * 60 * 60 * 24 * 30); // 默认还书期限为30天
                    html += '<td class="text-center">' + dateFormat('yyyy-MM-dd hh:mm:ss', lent_time);
                    +'</td>';

                    html += '<td class="container-fluid d-flex pt-2"><div class="flex-fill text-center">';
                    html += '<form action="book_info_page.php" method="GET">';
                    html +=
                        '<button type="submit" name="id" value="' +
                        value['b_id'] +
                        '" class="btn btn-primary"><i class="fa fa-share"></i></button>';
                    html += '</form></div></td></tr>';
                });
                $('#user-lent-books-table').html(html);
            } else {
                alert('请求失败，错误码：' + result.code);
            }
        }
    });
}

function createUserLentItemsForBook(book_id) {
    $.ajax({
        url: '../../api/user_lent_books.php?book_id=' + book_id,
        type: 'get',
        dataType: 'json',
        error: function() {
            alert('请求错误');
        },
        success: function(result) {
            if (result.code == 200) {
                var html = '';
                $.each(result.data, function(key, value) {
                    html += '<tr>';
                    html += '<td class="text-center">' + value['u_id'] + '</td>';
                    html += '<td class="text-center">' + value['name'] + '</td>';

                    var lent_time = new Date(value['lent_time']);
                    html += '<td class="text-center">' + dateFormat('yyyy-MM-dd hh:mm:ss', lent_time) + '</td>';
                    +'</td>';

                    html += '<td class="container-fluid d-flex pt-2"><div class="flex-fill text-center">';
                    html += '<form action="user_info_page.php" method="GET">';
                    html +=
                        '<button type="submit" name="id" value="' +
                        value['u_id'] +
                        '" class="btn btn-primary"><i class="fa fa-share"></i></button>';
                    html += '</form></div></td></tr>';
                });
                $('#users-lent-the-book-table').html(html);
            } else {
                alert('请求失败，错误码：' + result.code);
            }
        }
    });
}
