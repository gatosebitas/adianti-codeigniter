<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('meta'); ?>

    <link rel="stylesheet" href="<?php echo base_url('media/searchable-option-list-master/sol.css') ?>">
    <script src="<?php echo base_url('media/jquery-2.1.4.min.js') ?>">
    </script>
    <script defer src="<?php echo base_url('media/searchable-option-list-master/sol.js') ?>">
    </script>
</head>

<body>

    <?php TTransaction::open('database');
    $video_media = new ViewMedia(1);   
    TTransaction::close();
    ?>

    <video width="320" height="240" controls>
        <source src="<?php echo $video_media->path ?>" type="video/mp4">
    </video>

    <form action="logout" method="POST">
            
            <input type="submit" name="logout" value="logout" >
</form>

</body>

</html>