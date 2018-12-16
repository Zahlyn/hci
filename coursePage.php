<?php include 'partials/html-head.php'; ?>
    <div class="row">
        <div class="col-sm">
            <p>Now time for testing. Course page</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm">
            <div id="courseInfo">
            </div>
        </div>
        <div class="col-sm">
            <div id="indepthInfo">
                <h3> Next step, admission reqs and stuff </h3>
                <button type="button" id="enrollSubmit" onclick="enroll(false)" class="btn btn-primary">Enroll</button>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris 
                    nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in 
                    reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
                    deserunt mollit anim id est laborum.</p>
            </div>
        </div>
    </div>
    
    <?php
        $searchQuery = '';
        if (!empty($_GET)) {
            $searchQuery = $_GET['courseCode'];
        }
    ?>
    <script>
        function loadJson(searchQuery, category, program) {
            $(function(){
                var url = 'https://script.google.com/macros/s/AKfycbx5zKAL58XAs8GAWrIP0XHQsIbmSusaYtWDS6Y8-u9kB_09h7Y/exec';
                $.getJSON(url,function(data){
                    var html = $('#courseInfo').html();
                    console.log(html)
                    $.each(data, function(key,val){
                        if(val.length >= 8 && searchQuery == val[6].toUpperCase() ) {
                            console.log(val[0])
                            html += '<h1>' + val[0] + '</h1>';
                            html += '<h3>' + val[6] + '</h3>';
                            html += '<p>' + val[2] + '</p>';
                            
                        }
                    })
                    $('#courseInfo').html(html);
                    
                })
            })
        }

        function loadQuery() {
            var searchQuery = "<?php echo $searchQuery; ?>".toUpperCase();
            loadJson(searchQuery, '', '');
        }
        
        function loadEnrollStatus() {
            var courseArray = JSON.parse(window.sessionStorage.getItem("courseArray"));
            var searchQuery = "<?php echo $searchQuery; ?>".toUpperCase();
            for(j in courseArray) {
                if(courseArray[j] == searchQuery) {
                    $('#enrollSubmit').html("Unenroll");
                    $('#enrollSubmit').attr("onclick","enroll(true)");
                }
            }
            window.sessionStorage.setItem("courseArray", JSON.stringify(courseArray));
        }

        function enroll(alreadyEnrolled) {
            var searchQuery = "<?php echo $searchQuery; ?>".toUpperCase();
            if(alreadyEnrolled) { // unenroll
                var conf = confirm("Are you sure you wish to unenroll from this course?");
                if(conf) {
                    var courseArray = JSON.parse(window.sessionStorage.getItem("courseArray"));
                    for(j in courseArray) {
                        if(courseArray[j] == searchQuery) {
                            courseArray.splice(j,1);
                        }
                    }
                    window.sessionStorage.setItem("courseArray", JSON.stringify(courseArray));
                    location.reload();
                }
            } else { // enroll
                var conf = confirm("Are you sure you wish to enroll in this course?");
                if(conf) {
                    var courseArray = JSON.parse(window.sessionStorage.getItem("courseArray"));
                    var duplicate = false;
                    for(j in courseArray) {
                        if(courseArray[j] == searchQuery) {
                            duplicate = true;
                        }
                    }
                    if(!duplicate) {
                        courseArray.push(searchQuery);
                    }
                    window.sessionStorage.setItem("courseArray", JSON.stringify(courseArray));
                    location.reload();
                }
            }
        }

        function init() {    
            loadEnrollStatus();
            loadQuery();
        }

        $(document).ready(init);
    </script>
<?php include 'partials/html-footer.php'; ?>