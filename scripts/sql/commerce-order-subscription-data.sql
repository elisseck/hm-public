
SELECT o.order_id                              original_order,
       o.mail                                  order_email,
       o.billing_profile__target_id,
       ufd.name                                user_name,
       oi.order_item_id,
       oi.title,
       s.subscription_id,
       s.billing_schedule,
       s.state,
       from_unixtime(s.renewed)                subscription_renewed,
       from_unixtime(s.starts)                 subscription_starts,
       from_unixtime(s.ends)                   subscription_ends,
       cso.entity_id                           cso_entity_id,
       cso.orders_target_id,
       from_unixtime(cobp.billing_period_starts) cobp_billing_period_starts,
       from_unixtime(cobp.billing_period_ends) cobp_billing_period_ends

FROM drupal.commerce_subscription s -- start w/ subscription data.

       JOIN commerce_order o -- to get original order related to subscription
            ON s.initial_order = o.order_id

       JOIN commerce_order_item oi -- to get full list of items in order
            ON o.order_id = oi.order_id

       JOIN commerce_subscription__orders cso -- to ultimately get billing period end date
            ON s.subscription_id = cso.entity_id

       JOIN profile p -- to link to user profile
            ON o.billing_profile__target_id = p.profile_id

       JOIN users_field_data ufd -- for the username
            ON p.uid = ufd.uid

       JOIN commerce_order__billing_period cobp -- has the end date that will trigger the renewal
            ON cso.orders_target_id = cobp.entity_id

WHERE ufd.name = "MichMeadows";