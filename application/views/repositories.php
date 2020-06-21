<!DOCTYPE html>
<html lang="en">
<head>
	<title>Repositories</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <style>
        #accordion {
            margin: 60px;
        }
    </style>
</head>
    
<body>
    
    <div style="margin:55px;">
        <a href="<?php echo site_url('user/logout'); ?>">Logout</a>
    </div>
	
	<div id="accordion">
<?php
        $i = 1;
        foreach( $owner_repos as $ownerName => $repos ) {
?>
            <div class="card">
                <div class="card-header" id="heading_<?php echo $i ?>">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse_<?php echo $i ?>" aria-expanded="false" aria-controls="collapse_<?php echo $i ?>">
                            Owner Name: <?php echo $ownerName; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Repositories: <?php echo count( $repos ) ?>
                        </button>
                    </h5>
                </div>

                <div id="collapse_<?php echo $i ?>" class="collapse" aria-labelledby="heading_<?php echo $i ?>" data-parent="#accordion">
                    
<?php
                    foreach( $repos as $key => $repo ) {
?>
                        <div class="card-body">
                            <?php echo $key+1 ?>. &nbsp;&nbsp; <?php echo $repo[ 'description' ] ?>
                        </div>
<?php
                    }
?>
                </div>
            </div>
        
<?php
            $i++;
        }
        
        if( count( $owner_repos ) == 0 ) {
?>
            <div class="card">
                <div class="card-header" id="heading_1">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse_1" aria-expanded="false" aria-controls="collapse_1">
                            No Repositories found:
                        </button>
                    </h5>
                </div>

                <div id="collapse_1" class="collapse" aria-labelledby="heading_" data-parent="#accordion">
                        <div class="card-body">
                            0. &nbsp;&nbsp; 
                        </div>

                </div>
            </div>
<?php
        }
?>
        
    </div>

</body>
</html>