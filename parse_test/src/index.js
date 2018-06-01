var Papa = require('papaparse');
var CSV_PATH = 'http://localhost/unt-grade-distributions/static/UNT_Grade_Distribution_Request_2017-2018.csv';

//given two objects representing data from csv, check if they represent the same class
function sameClass(a, b){
    return (
            a.term === b.term
        &&  a.subject === b.subject
        &&  a.catalog === b.catalog
        &&  a.section === b.section
    );
}

document.addEventListener("DOMContentLoaded", function(event) {
    var rowNum = 0;
    var data = [];
    Papa.parse(CSV_PATH, {
        download: true,
        header: true,
        worker: true,
        step: function(row, errors) {
            var rowData = row.data[0];
            var item = {
                term: rowData.Term,
                subject: rowData.Subject,
                catalog: rowData.Catalog,
                section: rowData.Section,
                description: rowData.Descr,
                professor: rowData.Name,
                grades: {}
            };
            var letterGrade = rowData.Grade;
            item.grades[letterGrade] = rowData['Actual Number'];
            
            if(data.length && sameClass(item, data[data.length-1])){
                //this class is part of a course group
                //just add the grade to the old course
                data[data.length-1].grades[letterGrade] = item.grades[letterGrade];
            }else{
                data.push(item);
            }
            rowNum++;
        },
        complete: function() {
            console.log('done');
            console.log(data);
            document.getElementById("status").innerHTML = "done! check your console.";
        }
    });
});

