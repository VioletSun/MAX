# TODO

...list of what will be developed

## In development
- [ ] Migrations
    - [ ] max_send_schedule
- [ ] Models
    - [ ] MaxSendSchedule
- [ ] Enums
    - [ ] MarkupType
    - [ ] MessageLinkType
    - [ ] ReplyButtonType
- [ ] Objects
    - [ ] Update
        - [ ] message
          - [ ] link
          - [ ] stat
          - [ ] url
- [ ] Methods
    - [ ] Max::subscriptionInitSetting() add to url route('api.max.webhook')
    - [ ] Max::update()
        - [ ] link
        - [ ] enqueue
    - [ ] Max::videoInfo()
    - [ ] Max::messageInfo()
- [ ] Route Webhook with settings path, update_types and secret
- [ ] UnitTest
- [ ] Service handle update
- [ ] Queue
- [ ] Commands
    - [ ] max:webhook:init
    - [ ] max:update
    - [ ] max:send:schedule
- [ ] Supervisor

## Documentation

- [ ] I have to get started...

Support MAX
- Long Polling (GET /updates) не планируется как основной способ работы и не является заменой webhook.
- Он оставляется только для разработки и тестирования, а для production используется webhook через /subscriptions.
