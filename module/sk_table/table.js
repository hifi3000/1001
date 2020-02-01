$(document).ready(function () {
  $('.button').mouseup(function() { this.blur() })
  document.getElementById('tableToggle').style.display = "none";
});

function selectElementContents(el) {
  var body = document.body, range, sel;
  if (document.createRange && window.getSelection) {
    range = document.createRange();
    sel = window.getSelection();
    sel.removeAllRanges();
    try {
      range.selectNodeContents(el);
      sel.addRange(range);
    } catch (e) {
      console.log('that')
      range.selectNode(el);
      sel.addRange(range);
    }
  }
  else if (body.createTextRange) {
    range = body.createTextRange();
    range.moveToElementText(el);
    range.select();
  }
}

function toggleMe(tab) {
  var x = tab;
  if (x.style.display === "none") {
    x.style.display = "";
  }
  else {
    x.style.display = "none";
  }
}