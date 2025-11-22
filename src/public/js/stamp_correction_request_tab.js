
function showTab(tab) {
    // すべてのタブ内容を非表示
    document.querySelectorAll('.tab-content').forEach(content => {
        content.style.display = 'none';
    });

    // 引数tabに合致するIDのcontentだけ表示
    const target = document.getElementById(tab + '-tab');
    if (target) {
        target.style.display = '';
    }

    // すべてのボタンからactiveを外す
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

    // 引数tabに合致するボタンだけactive
    document.querySelectorAll('.tab-btn').forEach(btn => {
        if (btn.getAttribute('onclick') === `showTab('${tab}')`) {
        btn.classList.add('active');
        }
    });
}