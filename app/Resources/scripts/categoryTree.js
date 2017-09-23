
    $(function () {
        $("#tree").dynatree({
            onActivate: function (node) {
                $('#renamedValue').val(node.data.title);
            },
            //persist: true,
            initAjax: {
                url: "{{ path('get_category_tree') }}",
                data: {
                    key: "1",
                }
            },
            /*onLazyRead: function(node){
             node.appendAjax({url: "{{ path('get_category_branch') }}",
             data: {"key": node.data.key,
             }
             });
             },*/
            selectMode: 3,
            dnd: {
                onDragStart: function (node) {
                    /** This function MUST be defined to enable dragging for the tree.
                     *  Return false to cancel dragging of node.
                     */
                    logMsg("tree.onDragStart(%o)", node);
                    return true;
                },
                onDragStop: function (node, sourceNode) {
                    // This function is optional.
                    logMsg("tree.onDragStop(%o)", node);
                    var parentId = node.parent.data.key;
                    if (parentId === '_1') parentId = '1';
                    $.ajax({
                        type: "POST",
                        url: "{{ path('category_change_parent') }}",
                        data: "node=" + node.data.key + "&parent=" + parentId,
                        success: function (response) {
                            $('#response').html(response);
                        }
                    });
                },
                autoExpandMS: 1000,
                preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
                onDragEnter: function (node, sourceNode) {
                    /** sourceNode may be null for non-dynatree droppables.
                     *  Return false to disallow dropping on node. In this case
                     *  onDragOver and onDragLeave are not called.
                     *  Return 'over', 'before, or 'after' to force a hitMode.
                     *  Return ['before', 'after'] to restrict available hitModes.
                     *  Any other return value will calc the hitMode from the cursor position.
                     */
                    logMsg("tree.onDragEnter(%o, %o)", node, sourceNode);
                    return true;
                },
                onDragOver: function (node, sourceNode, hitMode) {
                    /** Return false to disallow dropping this node.
                     *
                     */
                    logMsg("tree.onDragOver(%o, %o, %o)", node, sourceNode, hitMode);
                    // Prevent dropping a parent below it's own child
                    if (node.isDescendantOf(sourceNode)) {
                        return false;
                    }
                    // Prohibit creating childs in non-folders (only sorting allowed)
                    if (!node.data.isFolder && hitMode === "over") {
                        return "after";
                    }
                },
                onDrop: function (node, sourceNode, hitMode, ui, draggable) {
                    /** This function MUST be defined to enable dropping of items on
                     * the tree.
                     */
                    logMsg("tree.onDrop(%o, %o, %s)", node, sourceNode, hitMode);
                    sourceNode.move(node, hitMode);
                    // expand the drop target
                    sourceNode.expand(true);
                },
                onDragLeave: function (node, sourceNode) {
                    /** Always called if onDragEnter was called.
                     */
                    logMsg("tree.onDragLeave(%o, %o)", node, sourceNode);
                }
            }
        });
    });

window.onload = function () {
    $("#tree").dynatree("getRoot").visit(function (node) {
        node.expand(true);
    });
};

function addNode() {
    var node = $("#tree").dynatree("getActiveNode");
    if (!node) node = $("#tree").dynatree("getRoot");
    $("#tree").dynatree("getActiveNode").expand(true);
    var childNode = node.addChild({
        title: "New node",
        tooltip: "This folder and all child nodes were added programmatically."
    });
    $.ajax({
        type: "POST",
        url: "{{ path('category_add') }}",
        data: "name=" + childNode.data.title + "&parent=" + node.data.key,
        success: function (response) {
            childNode.data.key = response;
        }
    });
}
function deleteNode() {
    var node = $("#tree").dynatree("getActiveNode");
    if (confirm("Are you sure?") === true) {
        $.ajax({
            type: "POST",
            url: "{{ path('category_delete') }}",
            data: "node=" + node.data.key,
            success: function (response) {
                $('#response').html(response);
            }
        });
        node.remove();
    }
    return true;
}

    /**
     * Implement inline editing for a dynatree node
     */
        function editNode(node) {
        var prevTitle = node.data.title,
            tree = node.tree;
        // Disable dynatree mouse- and key handling
        tree.$widget.unbind();
        // Replace node with <input>
        $(".dynatree-title", node.span).html("<input id='editNode' value='" + prevTitle + "'>");
        // Focus <input> and bind keyboard handler
        $("input#editNode")
            .focus()
            .keydown(function (event) {
                switch (event.which) {
                    case 27: // [esc]
                        // discard changes on [esc]
                        $("input#editNode").val(prevTitle);
                        $(this).blur();
                        break;
                    case 13: // [enter]
                        // simulate blur to accept new value
                        $(this).blur();
                        break;
                }
            }).blur(function (event) {
            // Accept new value, when user leaves <input>
            var title = $("input#editNode").val();
            node.setTitle(title);
            $.ajax({
                type: "POST",
                url: "{{ path('category_rename') }}",
                data: "node=" + node.data.key + "&title=" + title,
                success: function (response) {
                    $('#response').html(response);
                }
            });
            // Re-enable mouse and keyboard handlling
            tree.$widget.bind();
            node.focus();
        });
    }

// ----------

$(function () {
    var isMac = /Mac/.test(navigator.platform);
    $("#tree").dynatree({
        title: "Event samples",
        onClick: function (node, event) {
            if (event.shiftKey) {
                editNode(node);
                return false;
            }
        },
        onDblClick: function (node, event) {
            editNode(node);
            return false;
        },
        onKeydown: function (node, event) {
            switch (event.which) {
                case 113: // [F2]
                    editNode(node);
                    return false;
                case 13: // [enter]
                    if (isMac) {
                        editNode(node);
                        return false;
                    }
            }
        }
    });
});
