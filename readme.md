Timestamp Puzzle Solution
===

My solution to a test:

```
Write a PHP program that generates an XML file containing every 30th of June since 
the Unix Epoch, at 1pm GMT, similar to the one attached.

<?xml version="1.0" encoding="UTF-8"?>
<timestamps>
<timestamp time="1246406400" text="2009-06-30 13:00:00" />
</timestamps>

The program must also parse the generated XML file and generate a second XML file sorted 
by timestamp in descending order, excluding years that are prime numbers. The timestamps 
generated should be at 1pm PST.

We must be able to run these steps separately. 

Remember, you need to solve the problem but also show us your knowledge of professional PHP coding and OOP. 
```