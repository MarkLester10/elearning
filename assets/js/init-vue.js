new Vue({
  el: "#app",
  data: {
    message: "",
    is_created: 0,
    classes: [],
    faculty_id:
      document.querySelector("#faculty_id") != null
        ? parseInt(document.querySelector("#faculty_id").value)
        : "",
    subjects: [],
    department_id: "",
    url: "http://localhost/lms/app/controllers/admin/FacultyController.php",
    newClass: {
      department_id: "",
      subject_schedule_id: "",
      google_meet_link: "",
      faculty_id:
        document.querySelector("#faculty_id") != null
          ? parseInt(document.querySelector("#faculty_id").value)
          : "",
    },
  },

  methods: {
    getSubjects: function () {
      this.newClass.department_id = this.department_id;
      axios
        .get(
          `http://localhost/lms/app/controllers/admin/FacultyController.php?dept_id=${this.department_id}`
        )
        .then((res) => (this.subjects = res.data.subjects));
    },
    addClass: function () {
      var formData = this.toFormData(this.newClass);
      axios
        .post(
          "http://localhost/lms/app/controllers/admin/FacultyController.php?action=add_class",
          formData
        )
        .then((res) => {
          this.is_created =
            res.data.is_created == undefined ? 0 : res.data.is_created;
          this.message = res.data.message == "" ? "" : res.data.message;
          this.fetchAllClass();
          // this.is_created = 0;
          // this.message = "";
          this.newClass.department_id = "";
          this.newClass.subject_schedule_id = "";
          this.newClass.google_meet_link = "";
        });
    },

    fetchAllClass: function () {
      axios
        .get(
          `http://localhost/lms/app/controllers/admin/FacultyController.php?faculty_id=${this.faculty_id}`
        )
        .then((res) => {
          this.classes = res.data.classes;
        });
    },
    toFormData: function (obj) {
      var fd = new FormData();
      for (var i in obj) {
        fd.append(i, obj[i]);
      }
      return fd;
    },
  },
  mounted: function () {
    this.fetchAllClass();
  },
});
