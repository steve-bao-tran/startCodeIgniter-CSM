var AlbumsLists = new Vue({
  el: "#root",
  data: {
    debug: DEBUGMODE,
    albums: [],
    tableView: false,
    loader: true,
    filter: "",
  },
  mixins: [mixins],
  computed: {
    filterData: function () {
      if (!!this.filter) {
        let filterTerm = this.filter.toLowerCase();
        return this.albums.filter((value, index) => {
          return this.searchInObject(value, filterTerm);
        });
      } else {
        return this.albums;
      }
    },
  },
  methods: {
    toggleView: function () {
      this.tableView = !this.tableView;
      this.initPlugins();
    },
    resetFilter: function () {
      this.filter = "";
    },
    getPageImagePath(album, index) {
      let item = album.items[index] ? album.items[index] : { file: {} };
      if (item.file.file_front_path) {
        return (
          BASEURL +
          item.file.file_front_path
        );
      }
      return BASEURL + "public/img/default.jpg";
    },
    getPages: function () {
      var self = this;
      $.ajax({
        type: "GET",
        url: BASEURL + "api/v1/albumes/",
        data: {},
        dataType: "json",
        success: function (response) {
          self.albums = response.data;
          self.albums.map((element) => {
            element.user = new User(element.user);
            return element;
          });
          setTimeout(() => {
            self.loader = false;
            self.initPlugins();
          }, 1000);
        },
        error: function (error) {
          M.toast({ html: response.responseJSON.error_message });
          self.loader = false;
        },
      });
    },
    deletePage: function (page, index) {
      var self = this;
      self.loader = true;
      $.ajax({
        type: "DELETE",
        url: BASEURL + "api/v1/albumes/" + page.page_id,
        data: {},
        dataType: "json",
        success: function (response) {
          if (response.code == 200) {
            self.albums.splice(index, 1);
          }
          setTimeout(() => {
            self.loader = false;
            self.initPlugins();
          }, 1000);
        },
        error: function (error) {
          M.toast({ html: response.responseJSON.error_message });
          self.loader = false;
        },
      });
    },
    initPlugins: function () {
      setTimeout(() => {
        var elems = document.querySelectorAll(".tooltipped");
        M.Tooltip.init(elems, {});
        var elems = document.querySelectorAll(".dropdown-trigger");
        M.Dropdown.init(elems, {});
      }, 3000);
    },
  },
  mounted: function () {
    this.$nextTick(function () {
      this.getPages();
      this.initPlugins();
    });
  },
});
