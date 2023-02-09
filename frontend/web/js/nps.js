     /** Settings NPS comment */
     function showNpsComment(el) {
         let questin = $(el).parents('.nps-question-scale');
         let npsVal = parseInt($(el).val());

         const npsDataObj = JSON.parse(questin.find('.nps_diapasons_json').val());
         //  console.log(npsDataObj)
         let npsConditionIndex;

         for (let [key, element] of Object.entries(npsDataObj)) {
             //  console.log(key);
             if (npsVal >= element.npsDiapasoneStart && npsVal <= element.npsDiapasoneEnd) {
                 npsConditionIndex = key;
                 break;
             }
         }
         if (npsConditionIndex != undefined) {
             let element = npsDataObj[npsConditionIndex];
             if (element.npsTypeValue === "add_free_answer") {
                 //  console.log('show comment');
                 questin.find('.free-answers').fadeIn();
                 questin.find('.free-answers textarea').autoResize();
             } else {
                 questin.find('.free-answers').fadeOut();
             }

             if (element.npsTypeValue === "finish_survey") {
                 //  console.log('finish survey');
                 const form = document.querySelector('.form-valid');
                 form.submit();
             }
         } else {
             questin.find('.free-answers').fadeOut();
         }
     }

     $('.content-wrap').on('change', '.nps-question-scale .scale-wrap input', function () {
         showNpsComment(this);
     });

     $('.content-wrap').on('change', '.nps-question-scale .diapason input', function () {
         showNpsComment(this);
     });