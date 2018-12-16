<?php include 'partials/html-head.php'; ?>
    <div class="row">
        <div class="col-sm">
            <p>Now time for testing</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Course</th>
                        <th scope="col">Code</th>
                        <th scope="col">Units</th>
                    </tr>
                </thead>
                <tbody id="tableBody">

                </tbody>
            </table>
            <button type="button" id="enrollSubmit" onclick="unenroll()" class="btn btn-primary">Unenroll</button>
        </div>
    </div>        
    <script>
        function loadCourses() {
            var html = $('#tableBody').html();
            var courseArray = JSON.parse(window.sessionStorage.getItem("courseArray"));
            var url = 'https://script.google.com/macros/s/AKfycbx5zKAL58XAs8GAWrIP0XHQsIbmSusaYtWDS6Y8-u9kB_09h7Y/exec';
            $.getJSON(url,function(data){
                $.each(data, function(key,val){
                    for(i in courseArray) {
                        if(val.length >= 8 && courseArray[i] == val[6].toUpperCase()) {

                            html += '<tr>';
                            html += '<td><input type="checkbox" id="unenrollCheckbox' + key + '"</td>'
                            html += '<td><a href="coursePage.php?courseCode=' + val[6] + '">' + val[0] + '</a></td>';
                            html += '<td>' + val[6] + '</td>';
                            html += '<td>' + val[7] + '</td>';
                            html += '</tr>';
                        }
                    }
                })
                $('#tableBody').html(html);
            })
        }

        $(document).ready(loadCourses);

        function unenroll() {
            var conf = confirm("Are you sure you wish to unenroll from the course(s)?");
            if(conf) {
                var courseArray = JSON.parse(window.sessionStorage.getItem("courseArray"));
                var tableRows = document.getElementById('tableBody').children;
                var checkedCourses = 0;
                for(var i = 0; i < tableRows.length; i++) {
                    var row = tableRows[i];
                    if(row.children[0].children[0].checked) {
                        for(j in courseArray) {
                            if(courseArray[j] == row.children[2].innerHTML) {
                                courseArray.splice(j,1);
                                checkedCourses++;
                            }
                        }
                    }
                }
                window.sessionStorage.setItem("courseArray", JSON.stringify(courseArray));
                alert("Unenrolled successfully from " + checkedCourses + " course(s)!");
                location.reload();
            }
        }
    </script>
<?php include 'partials/html-footer.php'; ?>