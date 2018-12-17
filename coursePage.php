<?php include 'partials/html-head.php'; ?>

    <?php
        $searchQuery = '';
        if (!empty($_GET)) {
            $searchQuery = $_GET['courseCode'];
        }
    ?>
    
    <div class="row">
        <div class="col-7">
            <div id="courseInfo">
            </div>
        </div>
        <div class="col-5">
            <div id="nextStep" class="single-next-step">
            </div>
            <div id="indepthInfo" class="single-indepth-info">
                <button type="button" id="enrollButton" class="btn btn-primary single-enroll-unenroll" data-toggle="modal" data-target="#enrollSingleModal">Enroll</button>
            </div>
        </div>
    </div>

    <script>
        var alreadyEnrolled = false;

        function loadJson(searchQuery, category, program) {
            $(function(){
                var url = 'https://script.google.com/macros/s/AKfycbx5zKAL58XAs8GAWrIP0XHQsIbmSusaYtWDS6Y8-u9kB_09h7Y/exec';
                $.getJSON(url,function(data){
                    var htmlMain = $('#courseInfo').html();
                    var htmlAside = $('#indepthInfo').html();
                    var htmlNext = $('#nextStep').html();
                    var courseArrayEnrolled = JSON.parse(window.sessionStorage.getItem("courseArray"));
                    $.each(data, function(key,val){
                        if(val.length >= 8 && searchQuery == val[6].toString().toUpperCase() ) {
                            htmlMain += '<h1>' + val[0] + '</h1>';
                            htmlMain += '<span class="coursecode">' + val[6] + ' --- ' + val[11] + '</span>';
                            htmlMain += '<p>' + val[2].replace(/\r\n|\n|\r/g, '<br />') + '</p>';
                            htmlMain += '<h4>Objectives</h4><p>' + val[3].replace(/\r\n|\n|\r/g, '<br />') + '</p>';
                            
                            if(courseArrayEnrolled.indexOf(val[6]) != -1){
                                htmlNext += '<div class="next-step"><h5><i class="fas fa-exclamation-circle icon-next-step"></i> Next step</h5><p>Congratulations for successfully enrolling in ' + val[0] + '. Now all you got left to do is the following before the course start:</p><div class="single-steps"><ul><li>Enroll in Blackboard</li><li>Read through required reading for first class</li></ul></div></div>';
                            }

                            if(val[15] != ''){
                                htmlAside += '<h6>Admission Requirement</h6><p>' + val[15].replace(/\r\n|\n|\r/g, '<br />') + '</p>';
                            }
                            if(val[16] != ''){
                                htmlAside += '<h6>Time Table</h6><p>' + val[16].replace(/\r\n|\n|\r/g, '<br />') + '</p>';
                            }
                            if(val[17] != ''){
                                htmlAside += '<h6>Mode of Instruction</h6><p>' + val[17].replace(/\r\n|\n|\r/g, '<br />') + '</p>';
                            }
                            if(val[18] != ''){
                                htmlAside += '<h6>Assessment Method</h6><p>' + val[18].replace(/\r\n|\n|\r/g, '<br />') + '</p>';
                            }
                        }
                    })
                    $('#courseInfo').html(htmlMain);
                    $('#nextStep').html(htmlNext);
                    $('#indepthInfo').html(htmlAside);
                })
            })
        }

        function loadQuery() {
            var searchQuery = "<?php echo $searchQuery; ?>".toString().toUpperCase();
            loadJson(searchQuery, '', '');
        }
        
        function loadEnrollStatus() {
            var courseArray = JSON.parse(window.sessionStorage.getItem("courseArray"));
            var searchQuery = "<?php echo $searchQuery; ?>".toString().toUpperCase();
            for(j in courseArray) {
                if(courseArray[j] == searchQuery) {
                    $('#enrollButton').html("Unenroll");
                    $('#enrollButton').attr("data-target", "#unenrollSingleModal");
                    alreadyEnrolled = true;
                }
            }
            window.sessionStorage.setItem("courseArray", JSON.stringify(courseArray));
        }

        function enroll() {
            var searchQuery = "<?php echo $searchQuery; ?>".toString().toUpperCase();
            if(alreadyEnrolled) { // unenroll
                var courseArray = JSON.parse(window.sessionStorage.getItem("courseArray"));
                for(j in courseArray) {
                    if(courseArray[j] == searchQuery) {
                        courseArray.splice(j,1);
                    }
                }
                window.sessionStorage.setItem("courseArray", JSON.stringify(courseArray));
                $('#successMessage').html("Unenrolled successfully from this course!")
                $('#successModal').modal('show');
                
            } else { // enroll
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
                $('#successMessage').html("Enrolled successfully in this course!")
                $('#successModal').modal('show'); 
            }
        }

        function init() {    
            loadEnrollStatus();
            loadQuery();
        }

        $(document).ready(init);
    </script>
<?php include 'partials/html-footer.php'; ?>