<template>
  <div>
    <b-table
      striped
      hover
      outlined
      :fields="(editable || auditable) ? fieldsPersonal : fields"
      :items="items"
      @row-clicked="e => {e._showDetails = !e._showDetails}"
      class="gs-md"
    >
      <template v-slot:cell(id)="row">{{row.index +1 }}</template>
      <template v-slot:cell(name)="row">
        <b-link :href="row.item.address" target="_blank">{{ row.item.name }}</b-link>
      </template>
      <template v-slot:cell(_showDetails)="row">
        <b-button
          size="sm"
          @click="row.toggleDetails"
          class="mr-2"
          :class="{'btn-success':!row.detailsShowing}"
        >{{ row.detailsShowing ? '收合' : '詳情'}}</b-button>
      </template>
      <template v-slot:row-details="row">
        <b-card>
          <b-row align-v="center">
            <b-col cols="10">
              <b-row class="mb-1">
                <b-col cols="3" class>
                  <b>序號:</b>
                </b-col>
                <b-col>{{ row.item.id }}</b-col>
              </b-row>
              <b-row class="mb-1">
                <b-col cols="3" class>
                  <b>職缺內容描述:</b>
                </b-col>
                <b-col><pre>{{ row.item.description }}</pre></b-col>
              </b-row>
              <b-row class="mb-1">
                <b-col cols="3" class>
                  <b>工作待遇:</b>
                </b-col>
                <b-col>{{ row.item.offer }}</b-col>
              </b-row>
              <b-row class="mb-1">
                <b-col cols="3" class>
                  <b>上班地點:</b>
                </b-col>
                <b-col>{{row.item.location}}</b-col>
              </b-row>
              <b-row class="mb-1">
                <b-col cols="3" class>
                  <b>公司網址:</b>
                </b-col>
                <b-col>
                  <b-link
                    :href="row.item.company_Website"
                    target="_blank"
                  >{{ row.item.company_Website }}</b-link>
                </b-col>
              </b-row>
              <b-row class="mb-1">
                <b-col cols="3" class>
                  <b>聯絡人:</b>
                </b-col>
                <b-col>{{ row.item.contact_Name }}</b-col>
              </b-row>
              <b-row class="mb-1">
                <b-col cols="3" class>
                  <b>E-mail:</b>
                </b-col>
                <b-col>{{ row.item.contact_Mail }}</b-col>
              </b-row>
              <b-row class="mb-1">
                <b-col cols="3" class>
                  <b>連絡電話:</b>
                </b-col>
                <b-col>{{ row.item.contact_Phone }}</b-col>
              </b-row>
              <b-row class="mb-1">
                <b-col cols="3" class>
                  <b>方便聯絡時間:</b>
                </b-col>
                <b-col>{{ row.item.contact_Time }}</b-col>
              </b-row>
              <b-row v-if="editable || auditable" class="mb-1">
                <b-col cols="3" class>
                  <b>管理員建議:</b>
                </b-col>
                <b-col>{{ row.item.suggestion}}</b-col>
              </b-row>
            </b-col>
            <b-col cols="2" align="center">
              <b-button
                class="mb-2"
                size="sm"
                v-if="editable"
                variant="warning"
                @click="editItem(row.item)"
              >修改</b-button>
              <br />
              <b-button
                class="mb-2"
                size="sm"
                v-if="editable"
                variant="danger"
                @click="deleteItem(row.item)"
              >刪除</b-button>
              <br />
              <b-button
                class="mb-2"
                size="sm"
                v-if="auditable"
                variant="info"
                @click="auditItem(row.item)"
              >審核</b-button>
              <br />
              <b-button size="sm" @click="row.toggleDetails">收合</b-button>
            </b-col>
          </b-row>
        </b-card>
      </template>
    </b-table>
    <div class="ls-md">
      <template v-for="item in items">
        <b-card :key="item.id">
          <h4 class="d-inline-block">{{item.vacancy_Name}}</h4>
          <h6 class="d-inline-block text-muted">{{item.company_Name}}</h6>
          <h6 class="text-muted">{{item.M_Name + ' ' + item.verifyTime}}</h6>
          <b-card-text><pre>{{item.description}}</pre></b-card-text>
          <b-button variant="success" block @click="$bvModal.show('bv-modal-example'),focusItem=item">詳情</b-button>
          <div v-if="(editable || auditable)">
            <hr />
            <b-badge :variant="badgeVariant[item.status]">{{statusdesc[item.status]}}</b-badge>
            <b-card-text v-if="item.suggestion">
              <div class="card-subtitle text-muted">管理員建議</div>
              {{item.suggestion}}
            </b-card-text>
          </div>
          <template v-if="(editable || auditable)" v-slot:footer>
            <b-button block class="mr-2" v-if="editable" variant="warning" @click="editItem(item)">修改</b-button>
            <b-button block class="mr-2" v-if="editable" variant="danger" @click="deleteItem(item)">刪除</b-button>
            <b-button block class="mr-2" v-if="auditable" variant="info" @click="auditItem(item)">審核</b-button>
          </template>
        </b-card>
      </template>
    </div>
    <b-modal id="bv-modal-example" hide-footer>
      <template v-slot:modal-title>職缺詳情</template>
      <b-card>
        <b-row class="mb-1">
          <b-col cols="5">
            <b>序號:</b>
          </b-col>
          <b-col>{{ focusItem.id }}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5">
            <b>職缺名稱:</b>
          </b-col>
          <b-col>{{ focusItem.vacancy_Name }}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5">
            <b>公司名稱:</b>
          </b-col>
          <b-col>{{ focusItem.company_Name }}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5" class>
            <b>工作待遇:</b>
          </b-col>
          <b-col>{{ focusItem.offer }}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5" class>
            <b>上班地點:</b>
          </b-col>
          <b-col>{{focusItem.location}}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5" class>
            <b>公司網址:</b>
          </b-col>
          <b-col>
            <b-link
              :href="focusItem.company_Website"
              target="_blank"
            >{{ focusItem.company_Website }}</b-link>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5" class>
            <b>聯絡人:</b>
          </b-col>
          <b-col>{{ focusItem.contact_Name }}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5" class>
            <b>E-mail:</b>
          </b-col>
          <b-col>{{ focusItem.contact_Mail }}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5" class>
            <b>連絡電話:</b>
          </b-col>
          <b-col>{{ focusItem.contact_Phone }}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="5" class>
            <b>聯絡時間:</b>
          </b-col>
          <b-col>{{ focusItem.contact_Time }}</b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="12">
            <b>職缺內容描述:</b>
          </b-col>
          <b-col><div class="p-2 bg-light"><pre>{{ focusItem.description }}</pre></div></b-col>
        </b-row>
        <b-row v-if="editable || auditable" class="mb-1">
          <b-col cols="5" class>
            <b>管理員建議:</b>
          </b-col>
          <b-col>{{ focusItem.suggestion}}</b-col>
        </b-row>
      </b-card>
      <b-button class="mt-3" block @click="$bvModal.hide('bv-modal-example')">關閉</b-button>
    </b-modal>
  </div>
</template>
<script>
export default {
  props: {
    items: {
      type: Array,
      default: []
    },
    editable: { default: false },
    editItem: { type: Function },
    deleteItem: { type: Function },
    auditable: { default: false },
    auditItem: { type: Function }
  },
  components: {},
  data() {
    return {
      fields: [
        { key: "id", label: "NO" },
        { key: "vacancy_Name", label: "職缺名稱" },
        { key: "company_Name", label: "公司名稱" },
        { key: "M_Name", label: "發布人" },
        { key: "verifyTime", label: "發布日期" },
        { key: "_showDetails", label: "詳情" }
      ],
      fieldsPersonal: [
        { key: "id", label: "NO" },
        { key: "vacancy_Name", label: "職缺名稱" },
        { key: "company_Name", label: "公司名稱" },
        { key: "M_Name", label: "發布人" },
        { key: "verifyTime", label: "發布日期" },
        { key: "status", label: "狀態", formatter: e => this.statusdesc[e] },
        { key: "_showDetails", label: "詳情" }
      ],
      statusdesc: ["待審核", "審核通過", "審核不通過", "已隱藏"],
      badgeVariant:["secondary","success","danger","dark"],
      focusItem: {}
    };
  }
};
</script>