
## THM Related Makers

This module uses Apache Solr for efficient search capabilities.  
The server itself will remain inaccessible to the public, 
so an extra step is necessary to administer the system.

example: `ssh foobar@www.thehistorymakers.org -L 9000:localhost:8983`

This will route the server's port 8983 (default solr port)
to the local machine's port 9000.
