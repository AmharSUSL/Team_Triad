document.getElementById('profileButton').addEventListener('click', function() {
    alert('Profile button clicked!');
});
function execCmd(command, value = null) {
    document.execCommand(command, false, value);
}

document.addEventListener('DOMContentLoaded', function() {
    const editor = document.querySelector('.editor');
    editor.focus();
});
