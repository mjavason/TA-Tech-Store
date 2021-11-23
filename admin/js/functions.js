function htmlEntities(str) {
    return String(str)

        // .replace(/./g, '&#46;')
        // .replace(/#/g, '&#35;')
        .replace(/{/g, '&#123;')
        .replace(/}/g, '&#125;')
        .replace(/,/g, '&#44;')
        .replace(/:/g, '&#58;')
        .replace(/\"/g, '&#34;')
        .replace(/\'/g, '&#39;')
        .replace(/\//g, '&#47;')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
    .replace(/\n/g, "<br>").replace(/\r/g, "\\\\r").replace(/\t/g, "\\\\t");
}

function validateNewExamForm(numOfquestions, obj_or_theory) {

    var jsonta = document.getElementById("jsonta");
    var missing_num = document.getElementById("missing_num");


    if (obj_or_theory == 1) {


    } else {
        let qs_and_as = [];

        //arrays for holding question and answer textarea id's
        var qfields = [];
        var afields = [];
        var tfields = [];

        var missingNums = [];

        //names for question and answer textareas before number prefixes example: question1. 1 is added to 'question'.
        qtxtAreaName = 'question';
        atxtAreaName = 'answer';
        ttxtAreaName = 'topic';

        //this loops through the number of questions intended and adds the number prefixes as per how theyre numbered and made unique then adds them to an array for easy identification
        for (var i = 0; i <= numOfquestions; i++) {
            qfields[i] = qtxtAreaName + i;
            afields[i] = atxtAreaName + i;
            tfields[i] = ttxtAreaName + i;
        }

        var i, afieldname, qfieldname, tfieldname;

        //this loops through the array containing the names of the question and answer textareas and checks if they are empty
        for (i = 1; i <= numOfquestions; i++) {
            qfieldname = qfields[i];
            afieldname = afields[i];
            tfieldname = tfields[i];

            if (document.getElementById(qfieldname).value === "" || document.getElementById(afieldname).value === "" || document.getElementById(tfieldname).value === "") {
                console.log("Form field not filled");
                missingNums.push(i);

            } else {
                console.log("form field filled")

            }
        }

        //this sets the json textarea and error paragraph to nothing so new data can be added. 
        jsonta.innerHTML = "";
        missing_num.innerHTML = "";
        if (missingNums.length > 0) {


            for (var j = 0; j < missingNums.length; j++) {
                // missing_num.innerHTML += 'Missing Number ' + missingNums[j] + '\n';
                missing_num.innerHTML += 'Missing Num ' + missingNums[j] + ', ';
            }
        } else {
            for (i = 1; i <= numOfquestions; i++) {
                qfieldname = qfields[i];
                afieldname = afields[i];
                tfieldname = tfields[i];


                //example: {id:159223019, title, 'Deadpool', year:2015}
                // var qdata = CKEDITOR.instances.qfieldname.getData();
                // var adata = CKEDITOR.instances.afieldname.getData();

                let q_and_a = {
                    number: i,
                    question: htmlEntities(document.getElementById(qfieldname).value),
                    answer: htmlEntities(document.getElementById(afieldname).value),
                    topic: htmlEntities(document.getElementById(tfieldname).value)
                    // question: appEditorQ.getData(),
                    // answer: appEditorA.getData()
                }

                qs_and_as.push(q_and_a);

            }
            jsonta.innerHTML = JSON.stringify(qs_and_as, 't', 3);

        }

    }

}//end of obj or theory if statement

var focusedEle = "";

function setLastFocusedElement(elementId) {
    focusedEle = elementId;
    // console.log(focusedEle);
}

function setBluredElement() {
    focusedEle = "empty";
    //console.log(focusedEle);

}

function generateCQAPSL(originalArray) {
    console.log("Function Working");
    var generatedArray = [];
    for (var i = 0; i < originalArray.length; i++) {
        var mainStr = originalArray[0];
        originalArray.shift();

        console.log(stringSimilarity.findBestMatch(mainStr, originalArray));
    }

}

// function deliverQuestion


document.querySelector('#dataTable').onclick = function (ev) {
    var index = ev.target.parentElement.rowIndex;
    var row = document.getElementById("dataTable").rows[index].cells[0].innerHTML;

    if (focusedEle == "") { } else {
        var TA = document.getElementById(focusedEle);
        //var currentText = TA.textContent;
        //currentText += row;
        //TA.innerHTML = currentText;
        //TA.innerHTML += row;   
        TA.value += row;
        TA.focus();
        TA.selectionEnd;
    }

    // console.log(row);

    // alert(index);
}

$(document).ready(
    function () {
        // nav bar toggle
        $("#special_bar").click(function () {
            $("#dataTb").slideToggle();
        })

    })
































// function insertChar() {
//     var TA = document.getElementById("question1");
//     // //var spc = document.createTextNode("&OElig;");

//     // // TA.appendChild(spc);
//     // //TA.textContent += " &gt;";
//     //     var ev =  document.getElementById("dataTable");
//     // var tableRow = ev.target.parentElement.rowIndex;
//     //     TA.innerHTML +=  document.getElementById("dataTable").rows[tableRow].innerHTML;

//     //alert(document.getElementById("table").rows[0].innerHTML);

// }


// function createCkQuestion(size){
//     var num = 1;
// do{
// 	ClassicEditor
// 		.create( document.querySelector( '#question'+num ), {
// 			//toolbar: [ 'heading', '|', 'bold', 'italic', /*'link',*/ 'specialCharacters' ]
// 		} )
// 		.then( editor => {
// 			window.editor = editor;
// 		} )
// 		.catch( err => {
// 			console.error( err.stack );
// 		} )
// num++;
// 	}
// 	while(num <= size);
// }

