<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{pagetitle}</title>
        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        {caboose_styles}
     </head>
    <body>
        <div class="container">
            {navbar}
            <div class="jumbotron">
                <h3>{message}</h3>
                <p>{bodymessage}</p>
                {content}
            </div>
        </div>
        {caboose_scripts}
        {caboose_trailings}
    </body>
</html>