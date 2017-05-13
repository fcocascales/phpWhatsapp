# Renderize Whatsapp backup file to HTML

## Example

### 1) Input text
```
13/05/2017, 17:20 - Songoku: Lorem ipsum
13/05/2017, 17:28 - Bulma: Sed do eiusmod
13/05/2017, 17:22 - Songoku: Consectetur adipisicing elit
13/05/2017, 17:29 - Songoku: Ut enim ad minim veniam.
13/05/2017, 17:41 - Songoku: Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat
14/05/2017, 20:12 - Bulma: Duis aute irure dolor in reprehenderit in voluptate
14/05/2017, 20:13 - Bulma: Velit esse cillum dolore eu fugiat nulla pariatur
14/05/2017, 20:14 - Songoku: Excepteur sint occaecat cupidatat
14/05/2017, 20:15 - Bulma: Non proident
14/05/2017, 20:16 - Songoku: Sunt in culpa qui officia deserunt mollit anim id est laborum
14/05/2017, 20:17 - Bulma: Tempor
15/05/2017, 16:51 - Bulma: Incididunt ut labore et dolore magna aliqua
15/05/2017, 17:33 - Bulma: Dolor sit amet
15/05/2017, 17:33 - Songoku: Minim veniam
15/05/2017, 14:32 - Bulma: Ullamco laboris nisi ut aliquip
```

### 2) Output HTML

#### Renderization

![Browser image](example.png)


#### HTML code
```html
<div class="user user0">
  <div>
    <div class="text"><strong>Songoku</strong></div>
  </div>
</div>
<div class="user user1">
  <div>
    <div class="text"><strong>Bulma</strong></div>
  </div>
</div>
<div class="date">
  <div>sáb 13 de mayo de 2017</div>
</div>
<div class="user user0">
  <div>
    <div class="text">Lorem ipsum<br />
    </div>
    <div class="time">17:20</div>
  </div>
</div>
<div class="user user1">
  <div>
    <div class="text">Sed do eiusmod<br />
    </div>
    <div class="time">17:28</div>
  </div>
</div>
<div class="user user0">
  <div>
    <div class="text">Consectetur adipisicing elit<br />
    </div>
    <div class="time">17:22</div>
  </div>
</div>
<div class="user user0">
  <div>
    <div class="text">Ut enim ad minim veniam.<br />
    </div>
    <div class="time">17:29</div>
  </div>
</div>
<div class="user user0">
  <div>
    <div class="text">Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat<br />
    </div>
    <div class="time">17:41</div>
  </div>
</div>
<div class="date">
  <div>dom 14 de mayo de 2017</div>
</div>
<div class="user user1">
  <div>
    <div class="text">Duis aute irure dolor in reprehenderit in voluptate<br />
    </div>
    <div class="time">20:12</div>
  </div>
</div>
<div class="user user1">
  <div>
    <div class="text">Velit esse cillum dolore eu fugiat nulla pariatur<br />
    </div>
    <div class="time">20:13</div>
  </div>
</div>
<div class="user user0">
  <div>
    <div class="text">Excepteur sint occaecat cupidatat<br />
    </div>
    <div class="time">20:14</div>
  </div>
</div>
<div class="user user1">
  <div>
    <div class="text">Non proident<br />
    </div>
    <div class="time">20:15</div>
  </div>
</div>
<div class="user user0">
  <div>
    <div class="text">Sunt in culpa qui officia deserunt mollit anim id est laborum<br />
    </div>
    <div class="time">20:16</div>
  </div>
</div>
<div class="user user1">
  <div>
    <div class="text">Tempor<br />
    </div>
    <div class="time">20:17</div>
  </div>
</div>
<div class="date">
  <div>lun 15 de mayo de 2017</div>
</div>
<div class="user user1">
  <div>
    <div class="text">Incididunt ut labore et dolore magna aliqua<br />
    </div>
    <div class="time">16:51</div>
  </div>
</div>
<div class="user user1">
  <div>
    <div class="text">Dolor sit amet<br />
    </div>
    <div class="time">17:33</div>
  </div>
</div>
<div class="user user0">
  <div>
    <div class="text">Minim veniam<br />
    </div>
    <div class="time">17:33</div>
  </div>
</div>
<div class="user user1">
  <div>
    <div class="text">Ullamco laboris nisi ut aliquip<br />
    </div>
    <div class="time">14:32</div>
  </div>
</div>
```
