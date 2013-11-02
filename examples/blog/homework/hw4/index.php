<ul>
<li><b>Homework 1:</b> Answer the three questions asked in the course.<br/>
  <ol>
  <li>
    <p>Give the SELECT command to answer the question <span class="emph-alt">Who will go to the party held in Peking University?</span><p>
    <div class="ans">
    Intuitive way:<br/>
    <p class="sqlsrc">
    select Guest_Name from guest, `guest-party`, party <br/>
      where guest.Guest_ID=`guest-party`.Guest_ID and <br/>
      party.Party_Num=`guest-party`.Party_Num and <br/>
      Place="Peking University"<br/></p>
    A more efficient way: <br />
    <p class="sqlsrc">
    select Guest_Name from guest left join <br />
      (select Guest_ID, Place from `guest-party` left join <br/>
      party on `guest-party`.Party_Num=party.Party_Num) as tmp on guest.Guest_ID=tmp.Guest_ID<br/>
      where Place="Peking University"</p>
    </p>
  </li>
  <li>
    <p>Figure out a way to obtain the column labels returned by <span style="color:orange">mysql_fetch_array</span>.</p>
    <p class="ans">It is quite intuitive to use "desc table_name" to get column details. Yet we can obtain label names from the key values returned by array_keys($row) as well.For keys generated from array_keys($row), those with even number are numeric while others are with string type, i.e. label names. For example: 
    <a href="hw4/example.php">php example</a>
    </p>
  </li>
  <li>
    <p>Tell the difference between a CGI program and a PHP program executed by a Web Server.</p>
    <div class="ans">
    <ol>
    <li>CGI is a general technology which may be realized by either perl, python, c, etc. While PHP is a specific server-side scripting language.</li>
    <li>PHP generates webpage more efficient than CGI, since it can be embed into static html codes, we just need to write the dynamic part. </li>
    </ol>
    </div>
  </li>
  </ol>
</li>
<li><b>Homework 2:</b>
    <p>Set up PHP for your Apache and test it.</p>
    <p class="ans">Well, it works.</p>
</li>
<li><b>Homework 3:</b>
    <p>Transform the guest book that you implemented in week 3 into a Database version.</p>
    <p class="ans">Also implemented with AJAX technology, Please visit Here: 
    <a href="hw4/survey.php">Database version</a>
    </p>
</li>
<li><b>Homework 4:</b>
    <p>For homework3, only one Table is created. This time, create the other two tables, party table and party_guest table( you can choose different table names). Functions realized include:1)Guest can find out what parties will be given and when and where. 2)In additon to Guest name, Age, Gender, .... User can choose what parties he or she wants to go. 2)Separate PHP programs are provided for the organizer to input information about the parties will be given. </p>
    <p class="ans">Please visit Here: 
    <a href="hw4/queries.html">Queries to Databases.</a>
    </p>
</li>
<li><b>Homework 5:</b>
    <p>Realize more query functions.</p>
    <p class="ans">Same as homework 4.</p>

</li>
</ul>
