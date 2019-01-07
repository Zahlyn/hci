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
            <div class="loading">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
        </div>
        <div class="col-5">
            <div id="nextStep" class="single-next-step">
            </div>
            <div id="indepthInfo" class="single-indepth-info">
                <button type="button" id="enrollButton" class="btn btn-primary single-enroll-unenroll" data-toggle="modal" data-target="#enrollSingleModal">Enroll</button>
            </div>
            <div class="loading">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
        </div>
    </div>

    <script>
        $("body").tooltip({
            selector: '[data-toggle="tooltip"]'
        });
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
                            if(val[3] != ''){
                                htmlMain += '<h4>Objectives</h4><p>' + val[3].replace(/\r\n|\n|\r/g, '<br />') + '</p>';
                            }
                            
                            if(courseArrayEnrolled.indexOf(val[6]) != -1){
                                htmlNext += '<div class="next-step"><h5><i class="fas fa-exclamation-circle icon-next-step"></i> Next step</h5><p>Congratulations for successfully enrolling in ' + val[0] + '. Now all you got left to do is the following before the course start:</p><div class="single-steps"><ul><li>Sign up for the exam</li><li>Enroll in Blackboard</li><li>Read through required reading for first class</li></ul></div></div>';
                            }
                            htmlAside += '<div class="icon-detail-wrapper">'
                            if(val[12] == true){
                                htmlAside += '<span class="icon-detail"><i class="fas fa-book icon-true table-icon-list-single" data-toggle="tooltip" data-placement="right" title="Elective"></i>';
                                htmlAside += 'Elective</span>';
                            } else {
                                htmlAside += '<span class="icon-detail"><i class="fas fa-book icon-false table-icon-list-single" data-toggle="tooltip" data-placement="right" title="Not elective"></i>';
                                htmlAside += 'Not elective</span>';
                            }
                            if(val[13] == true){
                                htmlAside += '<span class="icon-detail"><i class="fas fa-arrows-alt-h icon-true table-icon-list-single" data-toggle="tooltip" data-placement="right" title="Exchange possible"></i>';
                                htmlAside += 'Exchange possible</span>';
                            } else {
                                htmlAside += '<span class="icon-detail"><i class="fas fa-arrows-alt-h icon-false table-icon-list-single" data-toggle="tooltip" data-placement="right" title="Exchange not possible"></i>';
                                htmlAside += 'Exchange not possible</span>';
                            }
                            if(val[14] == true){
                                htmlAside += '<span class="icon-detail"><i class="fas fa-globe-africa icon-true table-icon-list-single" data-toggle="tooltip" data-placement="right" title="Study abroad possible"></i>';
                                htmlAside += 'Study abroad possible</span>';
                            } else {
                                htmlAside += '<span class="icon-detail"><i class="fas fa-globe-africa icon-false table-icon-list-single" data-toggle="tooltip" data-placement="right" title="Study abroad not possible"></i>';
                                htmlAside += 'Study abroad not possible</span>';
                            }
                            htmlAside += '<br></div>'

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
                        if(searchQuery == val[10]) {
                            htmlMain += '<h5 class="exam-section-title">Examination elements for ' + val[0] + '</h5><div class="exam"><a class="exam-title" href="coursePage.php?courseCode=' + val[6] + '">' + val[0] + '</a><span class="exam-type"> ' + val[5] + ' ';
                            if(courseArrayEnrolled.indexOf(val[6]) != -1){
                                htmlMain += '- <b>You are enrolled</b></span>';
                            } else {
                                htmlMain += '- <b>You are not enrolled</b></span>';
                            }
                            htmlMain += '<a class="exam-view" href="coursePage.php?courseCode=' + val[6] + '">View</a></div>';
                        }
                        if(val[10] != '' && searchQuery == val[6]) {
                            htmlMain += '<h5 class="exam-section-title">This is part of the course: ' + val[0] + '</h5><div class="exam"><a class="exam-title" href="coursePage.php?courseCode=' + val[10] + '">' + val[0] + '</a> <span class="exam-type">Course ';
                            if(courseArrayEnrolled.indexOf(val[10]) != -1){
                                htmlMain += '- <b>You are enrolled</b></span>';
                            } else {
                                htmlMain += '- <b>You are not enrolled</b></span>';
                            }
                            htmlMain += '<a class="exam-view" href="coursePage.php?courseCode=' + val[10] + '">View</a></div>';
                        }
                    })
                    $('.loading').addClass('loading-gone');
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
