(function ($, root, window) {

    root.initTagsPage = function () {

        var url = "/admin/tags";
        var vent = _.extend({}, Backbone.Events);

        var TagsManagerRow = Backbone.View.extend({
            template: _.template($('#normal-template').html()),
            editTemplate: _.template($('#edit-template').html()),
            hiddenTemplate: _.template($('#hidden-template').html()),
            events: {
                "click .edit": "edit",
                "click .visibility": "visibility",
                "submit .update-form": "update"
            },
            render: function () {
                this.setElement(this.template({ item: this.model }));
                return this;
            },
            renderEdit: function () {
                this.setElement(this.editTemplate({ item: this.model }));
                return this;
            },
            renderHidden: function () {
                this.setElement(this.hiddenTemplate({ item: this.model }));
                return this;
            },
            edit: function () {
                this.model.editMode = true;
                vent.trigger('refresh.table');
            },
            update: function (e) {
                var newName = $(e.currentTarget).find('.name').val();
                if(newName.length) {
                    this.model.name = $(e.currentTarget).find('.name').val();
                    delete this.model.editMode;
                    this.updateModel();
                } else {
                    vent.trigger('delete.tag', this.model);
                }
                return false;
            },
            visibility: function () {
                this.model.hidden = Number(this.model.hidden) == 1 ? 0 : 1;
                this.updateModel();
                return false;
            },
            updateModel: function () {
                var data = {
                    type: this.model.label,
                    action: "update"
                };
                data.sortOrder = "";
                $.extend(data, this.model);
                root.send(url, data, function (result) {
                });
                vent.trigger('refresh.table');
            }
        });


        var Pagination = Backbone.View.extend({
            el: "",
            template: _.template($('#pagination-template').html()),
            model: {},
            events: {
                "click .goto_page": "changePage",
                "click .goto_prev": "pagePrev",
                "click .goto_next": "pageNext"
            },
            render: function (ext_count, ext_pagesize, current, model_name) {
                this.label = model_name;
                this.model.current = current;
                this.model.count = ext_count || this.model.count;
                this.model.size = ext_pagesize || this.model.pageSize;
                this.model.pages = Math.ceil(this.model.count/this.model.size);
                this.$el.html(this.template(this.model));
                return this;
            },
            changePage: function (el) {
                vent.trigger('table.changePage', { page: $(el.target).text(), model: this.label });
            },
            pagePrev: function () {
                vent.trigger('table.changePage', {
                    page: Number(this.model.current) - 1,
                    model: this.label
                });
            },
            pageNext: function () {
                vent.trigger('table.changePage', {
                    page: Number(this.model.current) + 1,
                    model: this.label
                });
            }
        });


        var TagsManager = Backbone.View.extend({
            el: "",
            collection: {},
            tagName: 'ul',
            pageSize: 20,
            page: 1,
            init: function () {
                this.render();
                this.$el = $(this.el);
                vent.on('refresh.table', this.render.bind(this));
                vent.on('delete.tag', _.debounce(this.removeTag.bind(this), 50));
                vent.on('table.changePage', _.debounce(this.changePage.bind(this), 50));
            },
            changePage: function (data) {
                if(data.page && data.model == this.model) {
                    this.page = data.page;
                    vent.trigger('refresh.table');
                }
            },
            render: function () {
                var offset = (this.page - 1) * this.pageSize;
                var filtered = $.grep(this.collection, function (val, i) {
                    return i+1 > offset;
                });

                this.$el.html('');
                $.each(filtered, function (i, item) {
                    item.label = this.model;
                    var row = new TagsManagerRow({ model: item });
                    if(item.editMode) {
                        this.$el.append(row.renderEdit().el);
                    } else if(Number(item.hidden) == 1)  {
                        this.$el.append(row.renderHidden().el);
                    } else {
                        this.$el.append(row.render().el);
                    }

                    if(i+2 > this.pageSize) return false;
                }.bind(this));

                if(this.collection.length > this.pageSize) {
                    var pagination = new Pagination({ el: $('#'+this.model+'-pagination') });
                    pagination.render(this.collection.length, this.pageSize, this.page, this.model);
                }
            },
            sort: function () {

            },
            removeTag: function (tag) {
                if(this.model == tag.label) {
                    this.collection = _.reject(this.collection, function (val) {
                        return val.id == tag.id && tag.label == val.label;
                    });
                    vent.trigger('refresh.table');

                    var data = {
                        action: "remove",
                        type: tag.label,
                        id: tag.id
                    };

                    root.send(url, data);
                }
            }
        });


        if($('#topics').length > 0) {
            var topics = new TagsManager({
                model: "topic",
                el: $('#topics'),
                collection: window.topics
            });
            topics.init();
            new window.Sortable.create(topics.el, {
                handle: ".move",
                onSort: function () {
                    var order = [];
                    $(this.el).find('.id').each(function (i, val) {
                        order[i] = $(val).data('id');
                    });
                    var data = {
                        action: "sort_topics",
                        order: order
                    };
                    root.send(url, data, function (result) {
                        if(typeof result == "string") {
                            topics.collection = eval("(" + result + ")");
                        } else {
                            topics.collection = result;
                        }
                        vent.trigger('refresh.table');
                    });
                },
                onMove: function (evt) {
                    $(evt.dragged).addClass('icc-sortable-test');
                }
            });
        }


        if($('#loses').length > 0) {
            var loses = new TagsManager({
                model: "los",
                el: $('#loses'),
                collection: window.loses
            });
            loses.init();
        }


        if($('#category').length > 0) {
            var category = new TagsManager({
                model: "category",
                el: $('#category'),
                collection: window.category
            });
            category.init();
        }



        $('#add-topic').on('submit', function (e) {
            $nameField = $('#add-topic').find('input.name');
            $name = $nameField.val().trim();
            if($name.length == 0){
                return false;
            }
            var data = {
                name: $name,
                action: "create",
                type: "topic"
            };
            root.send(url, data, function (result) {
                result.hidden = 0;
                topics.collection.push(result);
                vent.trigger('refresh.table');
            });

            $nameField.val('');
            e.preventDefault();
            return false;
        });




        $('#add-los').on('submit', function (e) {
            $nameField = $('#add-los').find('input.name');
            $name = $nameField.val().trim();
            if($name.length == 0){
                return false;
            }
            var data = {
                name: $name,
                action: "create",
                type: "los"
            };
            root.send(url, data, function (result) {
                result.hidden = 0;
                loses.collection.push(result);
                vent.trigger('refresh.table');
            });

            $nameField.val('');
            e.preventDefault();
            return false;
        });



        $('#add-category').on('submit', function (e) {
            $nameField = $('#add-category').find('input.name');
            $name = $nameField.val().trim();
            if($name.length == 0){
                return false;
            }
            var data = {
                name: $name,
                action: "create",
                type: "category"
            };
            root.send(url, data, function (result) {
                result.hidden = 0;
                category.collection.push(result);
                vent.trigger('refresh.table');
            });

            $nameField.val('');
            e.preventDefault();
            return false;
        });


    };

})(jQuery, main, window);