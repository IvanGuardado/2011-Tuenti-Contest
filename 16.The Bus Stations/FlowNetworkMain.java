import java.util.*;

class Edge
{   
    public String from;
    public String to;
    public Edge redge;
    public int capacity;
    public int flow;
    
    public Edge(String u, String v, int w)
    {
        from = u;
        to = v;
        capacity = w;
    }
}

class FlowNetwork
{
    int counter = 0;
    public HashMap<String,ArrayList<Edge>> adj = new HashMap<String,ArrayList<Edge>>();
    
    public void addVertex(String v)
    {
        if(adj.get(v) == null){
            adj.put(v, new ArrayList<Edge>());
        }
    }
    
    public void addEdge(String u, String v, int w)
    {
        Edge edge = new Edge(u, v, w);
        Edge redge = new Edge(v, u, 0);
        edge.redge = redge;
        redge.redge = edge;
        adj.get(u).add(edge);
        adj.get(v).add(redge);
    }
    
    public ArrayList<Edge> getEdges(String v)
    {
        return adj.get(v);
    }
    
    private void findPath(String source, String sink, LinkedList<Edge> path,
        ArrayList<String> visited)
    {
        if(source == sink){
            return;
        }

        for(Edge edge : getEdges(source)){
            if (edge.capacity-edge.flow > 0 && !visited.contains(edge.to)){
                visited.add(edge.from);
                //System.out.println(edge.from+"-"+edge.to);
                path.add(edge);
                findPath(edge.to, sink, path, visited);
            }
        }
        return;
    }
    
    public int getMaxFlow(String source, String sink)
    {
        ArrayList<String> visited = new ArrayList<String>();
        LinkedList<Edge> path = new LinkedList<Edge>();
        findPath(source, sink, path, visited);
        
        while(path.size() > 0){
            ArrayList<Integer> residuals = new ArrayList<Integer>();
            for(Edge e : path){
                residuals.add(e.capacity-e.flow);
                //System.out.println(e.capacity-e.flow);
            }
            //System.out.println("------");
            int k = Collections.min(residuals);
            for(Edge e : path){
                e.flow = e.flow + k;
                e.redge.flow = e.flow-k;
            }
            path = new LinkedList<Edge>();
            visited = new ArrayList<String>();
            findPath(source, sink, path, visited);
        }
        int sum = 0;
        for(Edge edge : getEdges(source)){
            sum += edge.flow;
        }
        
        return sum;
    }
}

public class FlowNetworkMain {
  
  public static void main(String[] args) {
    Scanner scan = new Scanner(System.in);
    Scanner data;
    String query;
    FlowNetwork f;
    while(scan.hasNextLine()){
        data = new Scanner(scan.nextLine().trim());
        f = new FlowNetwork();
        data.nextInt();
        String start = data.next();
        String sink = data.next();
        while(data.hasNext()){
            String t = data.next();
            String[] split = t.split(",");
            String from = split[0];
            String to = split[1];
            int w = Integer.parseInt(split[2]);
            f.addVertex(from);
            f.addVertex(to);
            f.addEdge(from, to, w);
        }
        System.out.println(f.getMaxFlow(start, sink));        
    }
  }  
}

