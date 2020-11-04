<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card mh-100vh">
          <div class="card-header">
            Dashboard
            <a class="btn btn-secondary ml-4" v-on:click="getEmails" href="#">Refresh</a>
          </div>
          <div class="lds-ellipsis" v-if="loading">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
          </div>
          <div class="card-body h-100">
            <h4
              class="text-center d-none"
              :class="{ 'd-block': emails.length === 0 && loading == false }"
            >Have no any items...</h4>
            <div class="alert alert-danger" role="alert" v-if="error.status"> 
             {{error.message}} Give us correct data, go to: <a href="/user-settings">IMAP data</a> 
            </div>
            <div class="row">
              <div class="col-12 col-md-6">
                <h4 :class="{ 'd-none': emails.length === 0 }">Unseen messages:</h4>
                <!-- List group -->
                <div class="list-group" id="myList" role="tablist">
                  <!-- <a class="list-group-item list-group-item-action active" data-toggle="list"
                  href="#home" role="tab">Home</a>-->
                  <a
                    class="list-group-item list-group-item-action"
                 
                    data-toggle="list"
                    v-for="email in emails"
                    :key="email.uid"
                    role="tab"
                    :href=" '#message' + email.uid"
                  >
                    <div class="row">
                      <div class="col-12 col-md-6">
                        <strong>{{email.subject}}</strong>
                        <br />
                        <small>{{email.date}}</small>
                      </div>
                      <div class="col-12 col-md-3">
                        <strong>{{email.from[0].mail}}</strong>
                      </div>
                      <div class="col-12 col-md-3">
                        <!-- {{route('createTicket', ['id' => $email->getUid()])}} -->
                      </div>
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <h4 :class="{ 'd-none': emails.length === 0 }">Content:</h4>
                <!-- Tab panes -->
                <div class="tab-content">
                  <div
                    class="tab-pane"
                   
                    :id="'message' + email.uid"
                    role="tabpanel"
                    v-for="(email, index) in emails"
                    :key="email.uid"
                  >
                    <a
                      class="btn btn-outline-success w-100 mb-4"
                      :href="'/create-ticket/' + email.uid"
                    >Create ticket</a>
                    <a
                      class="btn btn-outline-danger w-100 mb-4"
                      href="#"
                      v-on:click="markAsSeen(email.uid, index)"
                    >Mark as seen</a>
                    <div>
                      <iframe
                        :src="'/mail-body/' + email.uid"
                        frameborder="0"
                        class="w-100"
                        style="height: 400px;"
                      ></iframe>
                      <a :href="'/mail-body/' + email.uid" class="text-center d-block">Preview</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
    self = this;
    this.getEmails();
  },
  data: function() {
    return {
      emails: [],
      loading: true,
      error: {
        status: false,
        message: null
      }
       
      
    };
  },
  methods: {
    markAsSeen: function($uid, index) {
      this.emails.splice(index, 1);
      axios
        .get("/api/mark-as-seen/" + $uid)
        .then(function(response) {})
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .then(function() {});
    },
    getEmails: function(event) {
      self.loading = true;
      self.emails = [];
      axios
        .get("/api/catch-ticket-messages")
        .then(function(response) {
            console.log(response);
            axios
                .get("/api/dashboard-emails")
                .then(function(response) {
                // handle success
                self.emails = response.data;
                console.log(response.data);
                self.loading = false;
                })
                 .catch(function(error) {
                  // handle error
                  console.log(error);
                })
        }) .catch(function(error) {
            console.log(error.response.data.message);
            self.error = {
              status: true,
              message: error.response.data.message
            }; 

            self.loading = false;
        })
      
    }
  }
};
</script>
