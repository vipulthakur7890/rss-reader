<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSS Feed</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        <style>
        table {
            width: 100%;
            margin-top: 20px;
        }
        thead {
            cursor: pointer;
        }
        .desc-img a img {  width: 250px;

        }
    </style>
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">RSS Feed</h1>
        <input type="text" id="search" class="form-control" placeholder="Search...">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th data-sort="title">Title</th>
                    <th data-sort="description">Description</th>
                    <th data-sort="link">Link</th>
                    <th data-sort="guid">Guid</th>
                    <th data-sort="pubDate">Published Date</th>
                </tr>
            </thead>
            <tbody id="article-table">
                @foreach ($articles as $article)
                    <tr>
                        <td>{{ $article['title'] }}</td>
                        <td>{{ $article['description'] }}</td>
                        <td>{{ $article['link'] }}</td>
                        <td>{{ $article['guid'] }}</td>
                        <td>{{ $article['pubDate'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
                <!-- Pagination links will be added by JavaScript -->
            </ul>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            let articles = @json($articles);
            let currentPage = 1;
            let itemsPerPage = 10;
            let searchQuery = '';
            let sortKey = 'title';
            let sortOrder = 'asc';

            function renderTable() {
                let filteredArticles = articles.filter(article => 
                    article.title.toLowerCase().includes(searchQuery.toLowerCase())
                );

                if (sortOrder === 'asc') {
                    filteredArticles.sort((a, b) => a[sortKey].localeCompare(b[sortKey]));
                } else {
                    filteredArticles.sort((a, b) => b[sortKey].localeCompare(a[sortKey]));
                }

                let start = (currentPage - 1) * itemsPerPage;
                let end = start + itemsPerPage;
                let paginatedArticles = filteredArticles.slice(start, end);

                $('#article-table').html('');
                paginatedArticles.forEach(article => {
                    $('#article-table').append(`
                        <tr>
                            <td>${article.title}</td>
                            <td><sapam class="desc-img">${article.description}</spam></td>
                            <td>${article.link}</td>
                            <td>${article.guid}</td>
                            <td>${article.pubDate}</td>
                        </tr>
                    `);
                });

                renderPagination(filteredArticles.length);
            }

            function renderPagination(totalItems) {
                let totalPages = Math.ceil(totalItems / itemsPerPage);
                $('.pagination').html('');

                for (let i = 1; i <= totalPages; i++) {
                    $('.pagination').append(`
                        <li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="#">${i}</a>
                        </li>
                    `);
                }

                $('.page-link').click(function(event) {
                    event.preventDefault();
                    currentPage = parseInt($(this).text());
                    renderTable();
                });
            }

            $('#search').on('input', function() {
                searchQuery = $(this).val();
                currentPage = 1;
                renderTable();
            });

            $('th').click(function() {
                sortKey = $(this).data('sort');
                sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
                renderTable();
            });

            renderTable();
        });
    </script>
</body>
</html>
