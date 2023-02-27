<html>
    <head>
        <style>
        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
        }
        th, td {
          padding: 15px;
        }
        </style>
        </head>
<body>
    <h3>Thank you for answering the survey: {{ $response[0]->survey->title }}</h3>
    <table style="width:100%">
        <tr>
            <th>Question</th>
            <th>Answer</th>
        </tr>
        @foreach($response[0]->answers as $answer)
        <tr>
            <td>{{ $answer->question->content }}</td>
            <td>{{ $answer->answer }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>