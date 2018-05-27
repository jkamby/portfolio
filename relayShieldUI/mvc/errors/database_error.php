<!DOCTYPE html>
<html>
    <body>
        <main>
            <h1>Database Error</h1>
            <p>There was an error connecting to the database.</p>
            <p>The database must be installed using files in the database directory.</p>
            <p>Error message: <?php echo $error_message; ?></p>
            <p> <?php debug_print_backtrace(); ?></p>
        </main>
    </body>
</html>
