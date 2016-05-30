    function buildDomTree() {

        var data = [];

        function walk(nodes, data) {
            if (!nodes) { return; }
            $.each(nodes, function (id, node) {
                var obj = {
                    id: id,
                    text: (node.innerText ? 2 + node.innerText : ''),
                    tags: [node.childElementCount > 0 ? 1 + node.childElementCount + ' child elements' : ''],
                    href: node.href
                };
                if (node.childElementCount > 0) {
                    obj.nodes = [];
                    walk(node.children, obj.nodes);
                }
                data.push(obj);
            });
        }

        walk($('#languages')[0].children, data);
        return data;
    }

$(function() {

    var options = {
        bootstrap2: false,
        showTags: true,
        enableLinks: true,
        levels: 2,
        data: buildDomTree()
    };

    $('#treeview').treeview(options);
});