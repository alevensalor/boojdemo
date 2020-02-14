<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Booj Demo</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <style type="text/css" media="all">
            #moreOrLess {
                cursor: pointer;
                border: 1pt solid black;
                background-color: lightblue;
                padding-left: 5px;
            }

            .btn {
                cursor: pointer;
            }

            .tag-btn {
                margin-bottom: 3px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="jumbotron">
                <h1 class="display-3">Welcome!</h1>
                    <div id="moreOrLess">Less</div>
                    <div id="explain">
                        <p>Welcome to the demonstration! We've got a few things to look at here, so let's start with the postman
                            scripts you can use to test the API: [downloadable link here].
                        </p>
                        <p>Next, let's talk about the structure a little bit: I chose Laravel 5.8 for 2 reasons:
                        <ol><li>I was told this is the version Booj uses.</li>
                            <li>I needed an API and a user interface, so I used the full installation instead of Lumen.</li>
                        </ol>
                        <br />
                        <b>Note:</b> I did not add authetication or tokens to the API for this demo. I am aware of them and know how
                            to secure applications, however. JWT is what I've used in the past for that purpose.
                        </p>
                        <p>Additionally, there is no validation on the API fields, meaning you will be able to find all kinds of bugs using
                            blank input.
                        </p>
                    </div>
            </div>
            <div class="row">
                <table class="table">
                <tr>
                    <td>Title:</td><td><input type="text" id="bookTitle" /></td>
                    <td>Author(S):</td><td><input type="text" id="bookAuthors" /></td>
                    <td>Tags:</td><td><input type="text" id="bookTags" /></td>
                    <td><span class="btn btn-dark" id="addBook">Add Book</span></td>
                </tr>
                </table>
            </div>
            <div class="row">
                <div class="col-md-2">
                    Tags:<br />
                    <div id="tagDisplay">
                    @foreach ($tags as $tag)
                        <span class="btn btn-primary tag-btn" id="{{ $tag->id }}">{{ $tag->txt }}</span><br />
                    @endforeach
                    </div>
                    <span class="btn btn-primary tag-btn" id="-1">Clear</span>
                </div>
                <div class="col-md-8">
                    Books
                    <div id="bookDisplay">
                    @foreach ($books as $book)
                        <li>{{ $book->title }} (
                            @foreach($book->authors as $author)
                                {{ $author->name }},
                            @endforeach
                        )</li>
                    @endforeach
                    </div>
                </div>
                <div class="col-md-2">
                    Authors
                    <div id="authorDisplay">
                    @foreach ($authors as $author)
                        <li>{{ $author->name }}</li>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        $(function() {
            $('#moreOrLess').click(function() {
                if (this.innerHTML == 'Less') {
                    $('#explain').hide();
                    this.innerHTML = 'More';
                } else {
                    $('#explain').show();
                    this.innerHTML = 'Less';
                }
            });

            $('#addBook').click(addBook);

            $('.tag-btn').click(tagClick);

        });

        function tagClick() {
             $('.tag-btn').removeClass('btn-success').addClass('btn-primary');
            $(this).removeClass('btn-primary').addClass('btn-success');
            fetchBooksForTag(this.id);
        }


        function fetchBooksForTag(tagId) {
            $.ajax('/api/tags/' + tagId,
                {
                    dataType: 'json',
                    success: processTagLoad
                }
            );
        }

        function processTagLoad(data) {
            loadBooks(data.books);
        }

        function loadBooks(books) {
            let dispElm = $('#bookDisplay');
            dispElm.html("");
            let html = "";
            for (let i = 0; i < books.length; ++i) {
                html += '<li>' + books[i].title + ' (';

                for (let j = 0; j < books[i].authors.length; ++j) {
                    html += books[i].authors[j].name + ', ';
                }
                html += ')</li>';
            }
            dispElm.html(html);
        }

        function addBook() {
            $.ajax('/api/books',
                {
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        'title': $('#bookTitle').val(),
                        'authors': $('#bookAuthors').val().split(','),
                        'tags': $('#bookTags').val().split(',')
                    },
                    success: refreshAll
                });
            $('#bookTitle').val('');
            $('#bookAuthors').val('');
            $('#bookTags').val('');
        }

        function refreshAll() {
            fetchBooks();
            fetchTags();
            fetchAuthors();
        }

        function fetchTags() {
            $.ajax('/api/tags?sort=ASC',
            {
                success: loadTags,
                dataType: 'json'
            })
        }

        function loadTags(tags) {
            let dispElm = $('#tagDisplay');
            let html = "";
            for (let i = 0; i < tags.length; ++i) {
                html += '<span class="btn btn-primary tag-btn" id="' + tags[i].id + '">' + tags[i].txt + '</span><br />';
            }
            dispElm.html(html);
            $('.tag-btn').click(tagClick);
        }

        function fetchBooks() {
            $.ajax('/api/books',
            {
                success: loadBooks,
                dataType: 'json'
            });
        }


        function fetchAuthors() {
            $.ajax('/api/authors?sort=ASC',
                {
                    dataType: 'json',
                    success: loadAuthors
                });
        }

        function loadAuthors(authors) {
            let dispElm = $('#authorDisplay');
            let html = "";
            for (let i = 0; i < authors.length; ++i) {
                html += '<li>' + authors[i].name + '</li>';
            }
            dispElm.html(html);
        }
    </script>
</html>
